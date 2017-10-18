<?php

class Game extends BaseGame implements IStored, IAuth, IRegion
{
  const GAME_PLANNED = 0; //Запланирована
  const GAME_VERIFICATION = 100; //Игра на предстартовой проверке
  const GAME_READY = 200; //Готова к запуску
  const GAME_STEADY = 300; //Стартовала, но еще нет стартовавших команд.
  const GAME_ACTIVE = 400; //Играется
  const GAME_FINISHED = 800; //Завершена и ожидается награждение
  const GAME_ARCHIVED = 900; //Завершена и опубликованы результаты

  const VERIFY_WARN = 1;
  const VERIFY_ERR = 2;

  const MIN_UPDATE_INERVAL = 2; //Минимальное время между пересчетами состояний игры и прочих.

  //// IStored ////

  static function all()
  {
    return Utils::all('Game', 'start_datetime');
  }

  static function byId($id)
  {
    return Utils::byId('Game', $id);
  }

  //// IAuth ////

  static function isModerator(WebUser $account)
  {
    return $account->can(Permission::GAME_MODER, 0);
  }

  function canBeManaged(WebUser $account)
  {
    $res = $this->isManager($account);
    //Если разрешение еще не нашли
    if (!$res)
    {
      //Возможно пользователь может модерировать эту игру
      $res = $account->can(Permission::GAME_AUTHOR, $this->id)
          || $account->can(Permission::GAME_MODER, $this->id);
    }
    return $res;
  }

  function canBeObserved(WebUser $account)
  {
    $res = $this->isActor($account);
    //Если разрешение еще не нашли
    if (!$res)
    {
      //Возможно пользователь может принимать участие в организации этой игры
      $res = $account->can(Permission::GAME_ACTOR, $this->id)
          || $account->can(Permission::GAME_AUTHOR, $this->id)
          || $account->can(Permission::GAME_MODER, $this->id);
    }
    return $res;
  }

  //// IRegion ////

  public static function byRegion($region)
  {
    return Utils::byRegion('Game', $region, 'start_datetime');
  }
  
  public function getRegionSafe()
  {
    return Region::byIdSafe($this->region_id);
  }

  //// Public ////

	/**
	 * Возвращает запрос всех игр указанного региона. Допускает расширение только по andWhere.
	 * @param  Region $region
	 * @return Doctrine::Query
	 */
	public static function queryByRegion(Region $region)
	{
		return Doctrine::getTable('Game')
			->createQuery('g')
			->select()
			->where('g.region_id = ?', $region->id)
			->orderBy('g.start_datetime DESC');
	}

  // Info

  /**
   * Проверяет, входит ли игрок в состав команды организаторов.
   *
   * @param   WebUser  $player  Проверяемый пользователь
   * @return  boolean
   */
  public function isActor(WebUser $testedPlayer)
  {
    $res = false;
    //Если известна команда организаторов
    if ($this->team_id > 0)
    {
      //Если пользователь - организатор
      if ($this->Team->isPlayer($testedPlayer))
      {
        $res = true;
      }
    }
    return $res;
  }

  /**
   * Проверяет, входит ли игрок в состав команды организаторов.
   *
   * @param   WebUser  $player  Проверяемый пользователь
   * @return  boolean
   */
  public function isManager(WebUser $testedPlayer)
  {
    //Сданную в архив игру могут править только модераторы.
    if ($this->status >= Game::GAME_ARCHIVED)
    {
      return false;
    }
    if ($this->team_id > 0)
    {
      return $this->Team->isLeader($testedPlayer);
    }
    return false;
  }

  /**
   * Проверяет, зарегистрировна ли команда на игру.
   *
   * @param   Team      $testingTeam  Проверяемая команда
   * @return  boolean
   */
  public function isTeamRegistered(Team $testedTeam)
  {
    foreach ($this->teamStates as $teamState)
    {
      if ($teamState->team_id == $testedTeam->id)
      {
        return true;
      }
    }
    return false;
  }

   /**
   * Проверяет, подавала ли команда заявку на игру.
   *
   * @param   Team      $testingTeam  Проверяемая команда
   * @return  boolean
   */
  public function isTeamCandidate(Team $testedTeam)
  {
    foreach ($this->gameCandidates as $gameCandidate)
    {
      if ($gameCandidate->team_id == $testedTeam->id)
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Проверяет, входит ли игрок в состав какой-то из зарегистрированных команд.
   *
   * @param   WebUser  $player  Проверяемый пользователь
   * @return  boolean
   */
  public function isPlayerRegistered(WebUser $testedPlayer)
  {
    foreach ($this->teamStates as $teamState)
    {
      if ($teamState->Team->isPlayer($testedPlayer))
      {
        return true;
      }
    }
    return false;
  }

	/**
	 * Описывает состояние игры по коду статуса
	 *
	 * @return  string
	 */
	public function describeStatus()
	{
		switch ($this->status)
		{
			case Game::GAME_PLANNED: return 'Запланирована';
			case Game::GAME_VERIFICATION: return 'На проверке';
			case Game::GAME_READY: return 'Готова к старту';
			case Game::GAME_STEADY: return 'Стартует';
			case Game::GAME_ACTIVE: return 'Идет';
			case Game::GAME_FINISHED: return 'Финишировала';
			case Game::GAME_ARCHIVED: return 'Сдана в архив';
			default: return 'Неизвестно';
		}
	}

	/**
	 * Возвращает класс для выделения статуса цветом
	 *
	 * @return  string
	 */
	public function cssForStatus()
	{
		switch ($this->status)
		{
			case Game::GAME_PLANNED: return 'info';
			case Game::GAME_VERIFICATION: return 'warn';
			case Game::GAME_READY: return 'warn';
			case Game::GAME_STEADY: return 'warn';
			case Game::GAME_ACTIVE: return 'warn';
			case Game::GAME_FINISHED: return 'warn';
			case Game::GAME_ARCHIVED: return 'note';
			default: return 'Неизвестно';
		}
	}

	/**
	 * Возвращает описание ближайщего регламентного события
	 *
	 * @return  string
	 */
	public function describeNearestEvent()
	{
		switch ($this->status)
		{
			case Game::GAME_PLANNED: return 'Брифинг '.$this->start_briefing_datetime;
			case Game::GAME_VERIFICATION: return 'Брифинг '.$this->start_briefing_datetime;
			case Game::GAME_READY: return 'Стартует '.$this->start_datetime;
			case Game::GAME_STEADY: return 'Стартует '.$this->start_datetime;
			case Game::GAME_ACTIVE: return 'Остановка '.$this->stop_datetime;
			case Game::GAME_FINISHED: return 'Итоги '.$this->finish_briefing_datetime;
			case Game::GAME_ARCHIVED: return 'Завершена '.$this->finish_briefing_datetime;
			default: return 'Неизвестно';
		}
	}

  /**
   * Проверяет, находится ли игра в активной фазе.
   * 
   * @return  boolean
   */
  public function isActive()
  {
    /* Состояние GAME_FINISHED еще считается активным, так как не все команды
     * сразу узнают об окончании игры. После остановки игры нужно еще несколько
     * тактов пересчета на закрытие всех заданий.
     */
    return ($this->status >= Game::GAME_ACTIVE) && ($this->status <= Game::GAME_FINISHED);
  }

  /**
   * Проверяет, имеет ли смысл обновлять состояние игры.
   * 
   * @return  boolean
   */
  public function isUpdateValuable()
  {
    /* Состояние GAME_FINISHED еще считается активным, так как не все команды
     * сразу узнают об окончании игры. После остановки игры нужно еще несколько
     * тактов пересчета на закрытие всех заданий.
     */
    return ($this->status >= Game::GAME_STEADY) && ($this->status <= Game::GAME_FINISHED);
  }

  /**
   * Возвращает время принудительной остановки игры с учетом корректировок (время Unix)
   *
   * @return  integer
   */
  public function getGameStopTime()
  {
    return Timing::strToDate($this->stop_datetime);
  }

	/**
	 * Возвращает массив с результатами команд, отсортированными в порядке увеличения занимаемого места.
	 * Для каждой команды дается ассоциативная запись со следующми полями:
	 *    - 'teamState' - экземпляр состояния команды
	 *    - 'points' - набранные очки
	 *    - 'time' - потраченное время
	 *
	 * @return array
	 */
	public function getResults()
	{
		$res = array();
		foreach ($this->teamStates as $teamState)
		{
			$teamResults = $teamState->getTeamResults();
			$teamResultInfo = array('teamState' => $teamState, 'points' => $teamResults['points'], 'time' => $teamResults['time']);
			array_push($res, $teamResultInfo);
		}
		usort($res, 'compareTeamPlaces');
		return $res;
	}

  /**
   * Возвращает имя команды-организатора из архива.
   *
   * @return  string
   */
  public function getTeamBackupName()
  {
    if (($this->team_name_backup == null) || ($this->team_name_backup == ''))
    {
      return '(Авторы неизвестны)';
    }
    else
    {
      return $this->team_name_backup.' (Данные из архива)';
    }
  }

  /**
   * Возвращает список команд, от лица которых укзанный пользователь
   * может подавать заявки на игру
   *
   * @param   WebUser                     $webUser  пользователь
   *
   * @return  Doctrine_Collection<Team>
   */
  public function getTeamsAvailableToPostJoinBy(WebUser $webUser)
  {
    $teamList = new Doctrine_Collection('Team');
    foreach (Team::all() as $team)
    {
      if ($team->canBeManaged($webUser)
          && (!$this->isTeamRegistered($team))
          && (!$this->isTeamCandidate($team))
          && ($team->id != $this->team_id))
      {
        $teamList->add($team);
      }
    }
    return $teamList;
  }

	/**
	 * Возвращает список игр с активными анонсами.
	 * 
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesForAnnounce(Region $region)
	{
		return Game::queryByRegion($region)
			->andWhere('g.status <= ?', Game::GAME_FINISHED)
			->andWhere('g.short_info_enabled = ?', true)
			->execute();
	}

	/**
	 * Возвращает запланированные игры с фильтром по проекту, если указан.
	 * 
	 * @param  Region  $region
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesPlanned(Region $region)
	{
		return Game::queryByRegion($region)
			->andWhere('g.status < ?', Game::GAME_VERIFICATION)
			->execute();
	}

	/**
	 * Возвращает активные игры с фильтром по проекту, если указан.
	 * 
	 * @param  Region  $region
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesActive(Region $region)
	{
		return Game::queryByRegion($region)
			->andWhere('g.status >= ?', Game::GAME_VERIFICATION)
			->andWhere('g.status < ?', Game::GAME_ARCHIVED)
			->execute();
	}

	/**
	 * Возвращает игры, по которым подведены итоги, с фильтром по проекту, если указан.
	 * 
	 * @param  Region  $region
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesArchived(Region $region)
	{
		return Game::queryByRegion($region)
			->andWhere('g.status >= ?', Game::GAME_ARCHIVED)
			->execute();
	}

	/**
	 * Возвращает список всех игр, в которых пользователь так или иначе участвовал как игрок.
	 * 
	 * @param  WebUser  $user  Игрок
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesOfPlayer(WebUser $user)
	{
		$result = new Doctrine_Collection('Game');
		$userTeamsIds = DCTools::idsToArray(Team::getTeamsOfUser($user));
		if (count($userTeamsIds) > 0)
		{
			$query = Doctrine::getTable('TeamState')
				->createQuery('ts')
				->innerJoin('ts.Game')
				->select()
				->whereIn('ts.team_id', $userTeamsIds)
				->orderBy('ts.Game.start_datetime DESC')
				->execute();

			foreach ($query as $teamState) {
				$result->add($teamState->Game);
			}
		}

		return $result;
	}

	/**
	 * Возвращает список всех игр, в которые пользователь может играть сейчас.
	 * 
	 * @param  WebUser  $user  Игрок
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesOfPlayerActive(WebUser $user)
	{
		$games = Game::getGamesOfPlayer($user);

		$result = new Doctrine_Collection('Game');
		foreach ($games as $game) {
			if ($game->isActive())
			{
				$result->add($game);
			}
		}

		return $result;
	}

	/**
	 * Возвращает список всех игр, в которых игрок выступает как автор или агент.
	 * 
	 * @param  WebUser  $user  Игрок
	 * @return Doctrine_Collection<Game>
	 */
	public static function getGamesOfActor(WebUser $user)
	{
		$userTeamsIds = DCTools::idsToArray(Team::getTeamsOfUser($user));

		$query = Doctrine::getTable('Game')
			->createQuery('g')
			->select()
			->whereIn('g.team_id', $userTeamsIds)
			->orderBy('g.start_datetime DESC')
			->execute();

		$result = new Doctrine_Collection('Game');
		foreach ($query as $game) {
			$result->add($game);
		}

		return $result;
	}

	/**
	 * Возвращает список игр, в которых команда является организаторами, отсортированный по дате старта игры.
	 * 
	 * @param   Team  $team команда для отбора игр
	 * @return  Doctrine_Collection<Game>
	 */
	public static function getGamesTeamCreated(Team $team)
	{
		return Doctrine::getTable('Game')
			->createQuery('g')
			->select()
			->where('g.team_id = ?', $team->id)
			->orderBy('g.start_datetime DESC')
			->execute();
	}

	// Action

	/**
	 * Регистрирует заявку на игру от команды.
	 * Если заявка уже подана, то ничего не делает.
	 * Если команда уже зарегистрирована - ошибка.
	 *
	 * @param   Team      $team   Команда, подающая заявку
	 * @param   WebUser   $actor  Учетная запись, выполняющая операцию
	 * @return  string            True если все в порядке, иначе строковое описание ошибки
	 */
	public function postJoin(Team $team, WebUser $actor)
	{
		if ($this->short_info_enabled == 0)
		{
			return 'Игра не анонсирована.';
		}
		if (!$team->canBeManaged($actor) && !$this->canBeManaged($actor))
		{
			return 'Подать заявку от команды может только ее капитан.';
		}
		if (($this->status >= Game::GAME_READY) && !$this->canBeManaged($actor))
		{
			return 'Свободная регистрация на игру '.$this->name.' закрыта, так как игра скоро начнется. Обратитесь к организаторам игры.';
		}
		if ($this->isTeamCandidate($team))
		{
			return true;
		}
		if ($this->isTeamRegistered($team))
		{
			return 'Команда '.$team->name.' уже зарегистрирована на игру '.$this->name.'.';
		}
		if ($this->team_id == $team->id)
		{
			return 'Команда '.$team->name.' не может принимать участие в игре '.$this->name.' так как сама организует ее.';
		}

		$newCandidate = new GameCandidate;
		$newCandidate->team_id = $team->id;
		$newCandidate->game_id = $this->id;
		$newCandidate->save();
		return true;
	}

  /**
   * Отменяет поданную заявку на игру.
   * Если заявки нет - ничего не делает.
   *
   * @param   Team      $team   Команда, подавшая заявку
   * @param   WebUser   $actor  Учетная запись, выполняющая операцию
   * @return  string            True если все в порядке, иначе строковое описание ошибки
   */
  public function cancelJoin(Team $team, WebUser $actor)
  {
    if (!$this->canBeManaged($actor) && !$team->canBeManaged($actor))
    {
      return 'Отменить заявку на игру могут только руководитель игры или капитан команды, подавшей заявку.';
    }
    foreach ($this->gameCandidates as $gameCandidate)
    {
      if ($gameCandidate->team_id == $team->id)
      {
        $gameCandidate->delete();
      }
    }
    return true;
  }

  /**
   * Регистрирует команду на игру.
   * Если есть заявка на игру от этой команды, то убирает заявку.
   *
   * @param   Team      $team   Регистрируемая команда
   * @param   WebUser   $actor  Учетная запись, выполняющая операцию
   * @return  string            True если все в порядке, иначе строковое описание ошибки
   */
  public function registerTeam(Team $team, WebUser $actor)
  {
    if (!$this->canBeManaged($actor))
    {
      return 'Зарегистрировать команду на игру может только руководитель игры.';
    }
    if ($this->team_id > 0)
    {
      if ($this->team_id == $team->id)
      {
        return 'Команда '.$team->name.' не может принимать участие в игре '.$this->name.' так как сама организует ее.';
      }
    }
    if ($this->isTeamRegistered($team))
    {
      return true;
    }
    if ($this->isTeamCandidate($team))
    {
      $this->cancelJoin($team, $actor);
    }

    $newTeamStatus = new TeamState;
    $newTeamStatus->team_id = $team->id;
    $newTeamStatus->game_id = $this->id;
    $newTeamStatus->save();
    return true;
  }

  /**
   * Снимает команду с игры.
   *
   * @param   Team      $team   Снимаемая команда
   * @param   WebUser   $actor  Учетная запись, выполняющая операцию
   * @return  string            True если все в порядке, иначе строковое описание ошибки
   */
  public function unregisterTeam(Team $team, WebUser $actor)
  {
    if (!$this->canBeManaged($actor) && !$team->canBeManaged($actor))
    {
      return 'Снять команду с игры может только руководитель игры или капитан команды.';
    }
    foreach ($this->teamStates as $teamState)
    {
      if ($teamState->team_id == $team->id)
      {
        $teamState->delete();
      }
    }
    return true;
  }

  /**
   * Пересчитывает состояние игры (сохраняет в БД).
   * Если возникают ошибки, то возвращает их ассоциативным массивом:
   * - ключ - id команды
   * - данные - сообщение об ошибке
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе массив с ошибкой.
   */
  public function updateState(WebUser $actor)
  {
    if ( ! (Timing::isExpired(time(), Game::MIN_UPDATE_INERVAL, $this->game_last_update)
            &&
            $this->isUpdateValuable()) )
    {
      return true;
    }
    if (!$this->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
    }
    $res = true;
    switch ($this->status)
    {
      //Ожидание начала игры.
      case Game::GAME_STEADY:
        //Если уже можно начинать игру...
        if (time() >= Timing::strToDate($this->start_datetime))
        {
          $this->started_at = time();
          $this->status = Game::GAME_ACTIVE;
        }
        $res = true;
        break;

      //Нормальный ход игры.
      case Game::GAME_ACTIVE:
        //Проверим, может быть уже все команды финишировали.
        $allDone = true;
        foreach ($this->teamStates as $teamState)
        {
          if ($teamState->status < TeamState::TEAM_FINISHED)
          {
            $allDone = false;
            break;
          }
        }
        if ($allDone)
        {
          // Все команды финишировали, игру можно остановить.
          $this->stop($actor);
          $this->save();
        }
        // Принудительное окончание игры
        if (time() > $this->getGameStopTime())
        {
          $this->stop($actor);
          $this->save();
        }
        //Обновим состояние команд.
        $res = $this->updateTeamStates($actor);
        break;

      //Игра завершена
      case Game::GAME_FINISHED:
        //Обновления команд надо продолжать, чтобы все команды корректно закончили игру.
        //Обновим состояние команд.
        $res = $this->updateTeamStates($actor);
        break;

      default:
        $res = true;
        break;
    }

    $this->game_last_update = time();
    $this->save();

    return ($res);
  }

  /**
   * Выполняет перезапуск игры.
   * Не учитывает текущее ее состояние, просто удаляет всю информацию.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function reset(WebUser $actor)
  {
    if (!$this->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
    }

    /* Следующие две строки приводят к глюкам вроде попытки doctrine вставить
     * строчку без данных. С какого перепугу интересно?
      foreach ($this->teamStates as $teamState)
      { $teamState->reset(true, $actor); } */

    //Делаем через прямые обращения к БД, должно работать каскадное удаление.
    foreach ($this->teamStates as $teamState)
    {
      $query = Doctrine::getTable('TaskState')
              ->createQuery('tts')
              ->delete()
              ->where('team_state_id = ?', array($teamState->id))
              ->execute();

      $teamState->status = TeamState::TEAM_WAIT_GAME;
      $teamState->task_id = null;
      $teamState->started_at = 0;
      $teamState->finished_at = 0;
      $teamState->team_last_update = 0;
    }

    $this->status = Game::GAME_PLANNED;
    $this->started_at = 0;
    $this->finished_at = 0;
    $this->game_last_update = time();
    $this->save();

    return true;
  }

  /**
   * Проводит предыгровую проверку.
   * ВНИМАНИЕ: не сохраняет изменения в БД. Save() выполняет вызывающая сторона.
   * При наличии ошибок возвращает протокол в виде ассоциативного массива:
   * - ключ teams
   *    - ключ - id команды
   *      - ключ - порядковый номер сообщения в рамках команды
   *        - ключ errLevel - уровень проблемы
   *        - ключ msg - само сообщение
   * - ключ tasks
   *    - ключ - id заданий
   *      - ключи - порядковый номер сообщения в рамках задания
   *        - ключ errLevel - уровень проблемы
   *        - ключ msg - само сообщение
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успешной проверке, иначе протокол проверки.
   */
  public function prepare(WebUser $actor)
  {
    if (!$this->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
    }
    if ($this->status > Game::GAME_READY)
    {
      return 'Игра '.$this->name.' уже стартовала или завершена.';
    }

    $canStart = true;
    $report = array();

    $line = 0;

    //// Проверка заданий ////
    foreach ($this->tasks as $task)
    {
      /* Проверка подсказок */
      $hasTips = $task->tips->count() > 0;
      if ($hasTips)
      {
        /* Предупреждение о задании с ручным стартом. */
        if ($task->manual_start)
        {
          $line++;
          $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
          $report['tasks'][$task->id][$line]['msg'] = 'Задание запускается вручную, игра не может быть полностью автоматизирована.';
        }

        /* Проверка наличия подсказки без задержки, т.е. формулировки */
        $hasDefine = false;
        foreach ($task->tips as $tip)
        {
          if (($tip->delay == 0) && ($tip->answer_id == 0))
          {
            $hasDefine = true;
            break;
          }
        }
        if (!$hasDefine)
        {
          $line++;
          $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
          $report['tasks'][$task->id][$line]['msg'] = 'Задание не имеет формулировки (подсказки с нулевой задержкой выдачи).';
        }

        /* Проверка одновременных подсказок. */
        foreach ($task->tips as $tip)
        {
          foreach ($task->tips as $tip2)
          {
            //Если это не одна и та же подсказка
            //и совпадают задержки
            //и обе подсказки не являются дополнениями к кодам
            if (($tip2->id != $tip->id)
                && ($tip2->delay == $tip->delay)
                && (($tip2->answer_id <= 0) && ($tip->answer_id <= 0)))
            {
              $line++;
              $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
              $report['tasks'][$task->id][$line]['msg'] = 'Подсказки "'.$tip->name.'" и "'.$tip2->name.'" выдаются одновременно.';
            }
          }
        }
      }
      else
      {
        $line++;
        $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_ERR;
        $report['tasks'][$task->id][$line]['msg'] = 'Задание не имеет ни формулировки, ни подсказок.';
      }

      /* Проверка ответов */
      $hasAnswers = $task->answers->count() > 0;
      if ($hasAnswers)
      {
        /* Проверка корректности значений */
        foreach ($task->answers as $answer)
        {
          /* Проверка наличия видимых символов в описании. */
          if (trim($answer->info) === '')
          {
            $line++;
            $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
            $report['tasks'][$task->id][$line]['msg'] = 'Ответ "'.$answer->name.'" имеет невидимое описание.';
          }

          /* Проверка наличия невидимых символов в значении. */
          if (count(explode(' ', $answer->value)) > 1)
          {
            $line++;
            $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_ERR;
            $report['tasks'][$task->id][$line]['msg'] = 'Ответ "'.$answer->name.'" не может быть введен (содержит невидимые символы).';
          }
        }
        
        /* Проверка необходимого числа ответов */
        //Если требуется ответов больше чем есть - это не ошибка, просто
        //тогда зачет будет выполнен по всем имеющимся ответам.
        if (($task->min_answers_to_success > 0)
            && ($task->answers->count() < $task->min_answers_to_success))
        {
          $line++;
          $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
          $report['tasks'][$task->id][$line]['msg'] = 'В задании меньше ответов ('.$task->answers->count().') чем требуется для зачета ('.$task->min_answers_to_success.'), зачет будет выполнен по всем доступным ответам.';
        }
        
        /* Проверка персональных ответов */
        //Построим индекс, какой команде сколько ответов доступно.
        $answersPerTeamIndex = array();
        foreach ($this->teamStates as $teamState)
        {
          $answersPerTeam[$teamState->id]['teamName'] = $teamState->Team->name;
          $answersPerTeam[$teamState->id]['answerCount'] = $task->getTargetAnswersForTeam($teamState->Team)->count();
          if (($task->min_answers_to_success > 0)
              && ($answersPerTeam[$teamState->id]['answerCount'] < $task->min_answers_to_success))
          {
            $line++;
            $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
            $report['tasks'][$task->id][$line]['msg'] = 'Команде '.$answersPerTeam[$teamState->id]['teamName'].' не хватает ответов ('.$answersPerTeam[$teamState->id]['answerCount'].') для зачета ('.$task->min_answers_to_success.'), зачет будет выполнен по всем доступным ответам.';
          }
        }
        //Анализируем индекс
        $minAnswers = $task->answers->count();
        $maxAnswers = 0;
        foreach ($answersPerTeam as $indexItem)
        {
          if ($minAnswers > $indexItem['answerCount'])
          {
            $minAnswers = $indexItem['answerCount'];
          }
          if ($maxAnswers < $indexItem['answerCount'])
          {
            $maxAnswers = $indexItem['answerCount'];
          }
          if ($indexItem['answerCount'] == 0)
          {
            $line++;
            $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_ERR;
            $report['tasks'][$task->id][$line]['msg'] = 'У команды '.$indexItem['teamName'].' нет доступных ответов.';
          }
        }
        if ($maxAnswers <> $minAnswers)
          {
            $line++;
            $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
            $report['tasks'][$task->id][$line]['msg'] = 'У команд различное число доступных ответов: от '.$minAnswers.' до '.$maxAnswers.'.';
          }
      }
      else
      {
        $line++;
        $report['tasks'][$task->id][$line]['errLevel'] = Game::VERIFY_WARN;
        $report['tasks'][$task->id][$line]['msg'] = 'Задание не имеет ответов: будет зачтено успешным сразу после получения.';
      }
    }

    //// Проверка команд ////
    foreach ($this->teamStates as $teamState)
    {
      /* Проверка доступности игрового времени */
      $gameTimeAvailable = Timing::strToDate($this->stop_datetime) - Timing::strToDate($this->start_datetime) - $teamState->start_delay*60;
      if ($gameTimeAvailable < $this->time_per_game*60)
      {
        $line++;
        $report['teams'][$teamState->team_id][$line]['errLevel'] = Game::VERIFY_WARN;
        $report['teams'][$teamState->team_id][$line]['msg'] = 'Команде доступно на игру только '.Timing::intervalToStr($gameTimeAvailable).' из необходимых '.Timing::intervalToStr($this->time_per_game*60).'.';
      }
      /* Проверка наличия игроков и капитана */
      if ($teamState->Team->teamPlayers->count() <= 0)
      {
        $line++;
        $report['teams'][$teamState->team_id][$line]['errLevel'] = Game::VERIFY_WARN;
        $report['teams'][$teamState->team_id][$line]['msg'] = 'В команде нет игроков.';
      }
      else
      {
        /* Проверка наличия капитана. */
        if ($teamState->Team->getLeaders() === false)
        {
          $line++;
          $report['teams'][$teamState->team_id][$line]['errLevel'] = Game::VERIFY_WARN;
          $report['teams'][$teamState->team_id][$line]['msg'] = 'В команде нет капитана.';
        }
        /* Проверка вхождения игроков более чем в одну команду. */
        foreach ($teamState->Team->teamPlayers as $teamPlayer)
        {
          $player = $teamPlayer->WebUser;
          if ($this->team_id > 0)
          {
            if ($this->Team->isPlayer($player))
            {
              $line++;
              $report['teams'][$teamState->team_id][$line]['errLevel'] = Game::VERIFY_ERR;
              $report['teams'][$teamState->team_id][$line]['msg'] = 'Игрок '.$player->login.' также является организатором игры '.$this->name.'.';
              $canStart = false;
            }
          }
          foreach ($this->teamStates as $teamStatus2)
          {
            // Если команды не совпадают,
            // и игрок входит в другую команду...
            // и эта другая команда участвует в рассматриваемой игре
            if (   ($teamStatus2->team_id != $teamState->team_id)
                && ($teamStatus2->Team->isPlayer($player))
                && ($this->isTeamRegistered($teamStatus2->Team)))
            {
              $line++;
              $report['teams'][$teamState->team_id][$line]['errLevel'] = Game::VERIFY_ERR;
              $report['teams'][$teamState->team_id][$line]['msg'] = 'Игрок '.$player->login.' также играет еще и за команду '.$teamStatus2->Team->name.'.';
              $canStart = false;
            }
          }
        }
      }
    }

    $this->status = $canStart
        ? Game::GAME_READY
        : Game::GAME_VERIFICATION;
    $this->game_last_update = time();

    return ($line > 0)
        ? $report
        : true;
  }

  /**
   * Запускает игру.
   * ВНИМАНИЕ: не сохраняет изменения в БД. Save() выполняет вызывающая сторона.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function start(WebUser $actor)
  {
    if (!$this->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
    }
    if ($this->status < Game::GAME_READY)
    {
      return 'Игра '.$this->name.' еще не прошла предстартовую проверку.';
    }
    if ($this->status > Game::GAME_STEADY)
    {
      return 'Игра '.$this->name.' уже стартовала или завершена.';
    }

    $this->status = Game::GAME_STEADY;
    $this->started_at = 0; //Реальное время старта будет сюда записано при пересчете состояния, когда будет отслежен момент старта.
    $this->finished_at = 0;
    $this->game_last_update = time();

    return true;
  }

  /**
   * Останавливает игру.
   * После остановки требуется еще несколько итераций пересчета состояния,
   * чтобы закрылись все текущие задания и финишировали все команды.
   * ВНИМАНИЕ: не сохраняет изменения в БД. Save() выполняет вызывающая сторона.
   *
   * @param   WebUser   $actor      Исполнитель
   * @return  mixed                 True при успехе, иначе строка с ошибкой.
   */
  public function stop(WebUser $actor)
  {
    if (!$this->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
    }
    if ($this->status < Game::GAME_STEADY)
    {
      return 'Игра '.$this->name.' еще не стартовала.';
    }
    if ($this->status > Game::GAME_ACTIVE)
    {
      return 'Игра '.$this->name.' уже завершена.';
    }

    $this->status = Game::GAME_FINISHED;
    $this->finished_at = time();
    $this->game_last_update = time();

    return true;
  }

  /**
   * Переводит игру в архивное состояние.
   * ВНИМАНИЕ: не сохраняет изменения в БД. Save() выполняет вызывающая сторона.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function close(WebUser $actor)
  {
    if (!$this->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
    }
    if ($this->status < Game::GAME_FINISHED)
    {
      return 'Игра '.$this->name.' еще не финишировала.';
    }

    $activeTasks = false;
    foreach ($this->teamStates as $teamState)
    {
      if ($teamState->status != TeamState::TEAM_FINISHED)
      {
        $activeTasks = true;
        break;
      }
    }
    if ($activeTasks)
    {
      return 'Игра '.$this->name.' финишировала, но еще не все команды об этом узнали.';
    }

    $this->status = Game::GAME_ARCHIVED;
    $this->game_last_update = time();

    return true;
  }

  /**
   * Назначает исходные значения.
   */
  public function initDefaults()
  {
    if ($this->team_id > 0)
    {
      $this->team_name_backup = $this->Team->name;
    }
  }

  //// Self
  
  /** 
   * Обновляет состояние команд, возвращает список ошибок при этом.
   * 
   * @param   WebUser   $actor  Авторизация
   * 
   * @return  mixed     True при отсутствии ошибок, иначе массив-индекс [ключ_команды]="сообщение об ошибке"
   */
  protected function updateTeamStates(WebUser $actor)
  {
    $teamStateToSendTask = null;
    $errors = array();
    foreach ($this->teamStates as $teamState)
    {
      try
      {
        //Если команде назначено следующее задание
        //или она не ждет задания
        //или для нее выключен автовыбор заданий
        if (($teamState->task_id > 0)
            ||
            ($teamState->status != TeamState::TEAM_WAIT_TASK)
            ||
            ( ! $teamState->ai_enabled))
        {
          $teamState->updateState($actor);
        }
        else
        {
          //Задание выдается только одной из команд за всеь цикл обновления,
          //так как автоматический выбор задания требует интенсивного обмена с БД.
          $teamStateToSendTask = ($teamStateToSendTask === null) ? $teamState : $teamStateToSendTask;
        }
      }
      catch (Exception $e)
      {
        $errors[$teamState->team_id] = $e->getMessage();
      }
      
      if ($teamStateToSendTask !== null)
      {
        try
        {
          $teamStateToSendTask->updateState($actor); //Задание будет выдано в результате обновления состояния.
        }
        catch (Exception $e)
        {
          $errors[$teamState->team_id] = $e->getMessage();
        }
      }
    }
    return (count($errors) > 0) ? $errors : true;
  }
}

function compareTeamPlaces($a, $b)
{
  //Команды отличаются по очкам (прямой порядок)
  if ($a['points'] < $b['points'])
  {
    return 1;
  }
  elseif ($a['points'] > $b['points'])
  {
    return -1;
  }
  //Команды отличаются только по времени (обратный порядок)
  elseif ($a['time'] < $b['time'])
  {
    return -1;
  }
  elseif ($a['time'] > $b['time'])
  {
    return 1;
  }
  //Команды ничем не отличаются
  else
  {
    return 0;
  }
}
