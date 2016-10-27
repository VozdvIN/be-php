<?php

/**
 * TaskState
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class TaskState extends BaseTaskState implements IStored, IAuth
{
  const TASK_GIVEN = 0; // Только что назначено команде
  const TASK_STARTED = 100; // Разрешен старт
  const TASK_ACCEPTED = 200; // Команда ознакомилась с заданием и выполняет его
  const TASK_CHEAT_FOUND = 800; // Найдены нарушения
  const TASK_DONE = 900; // Опорный уровень статуса, сам по себе не используется.
  const TASK_DONE_SUCCESS = 910;
  const TASK_DONE_TIME_FAIL = 920;
  const TASK_DONE_SKIPPED = 930;
  const TASK_DONE_GAME_OVER = 940;
  const TASK_DONE_BANNED = 950;
  const TASK_DONE_ABANDONED = 960;

  //// IStored ////

  static function all()
  {
    return Utils::all('taskStatus');
  }

  static function byId($id)
  {
    return Utils::byId('TaskState', $id);
  }

  //// IAuth ////

  static function isModerator(WebUser $account)
  {
    return TeamState::isModerator($account);
  }

  function canBeManaged(WebUser $account)
  {
    return $this->TeamState->canBeManaged($account);
  }

  function canBeObserved(WebUser $account)
  {
    return $this->TeamState->canBeObserved($account);
  }

  //// Public ////
  // Info

  /**
   * Проверяет, обладает ли пользователь правом обновлять состояние задания
   * 
   * @param WebUser $account 
   */
  public function canUpdateState(WebUser $account)
  {
    if (!$this->TeamState->Game->teams_can_update)
    {
      // Пересчет состояния допустим только руководителем игры, проверим
      return $this->canBeManaged($account);
    }
    else
    {
      // Пересчет состояния допустим как руководителем, так и любым игроком
      return ($this->TeamState->Team->isPlayer($account)) || $this->canBeManaged($account);
      /* Проверка на то, что команда зарегистрирована, не нужна, так как
       * экземпляр состояния команды создается только при регистрации.
       */
    }    
  }
  
  /**
   * Описывает состояние задания по коду статуса
   *
   * @param   integer   $aStatus  Код статуса
   * @return  string
   */
  public function describeStatus()
  {
    switch ($this->status)
    {
      case TaskState::TASK_GIVEN: return 'Выдано';
        break;
      case TaskState::TASK_STARTED: return 'Стартовало';
        break;
      case TaskState::TASK_ACCEPTED: return 'Выполняется';
        break;
      case TaskState::TASK_CHEAT_FOUND: return 'Дисквалифицируется';
        break;
      case TaskState::TASK_DONE: return 'Завершено';
        break;
      case TaskState::TASK_DONE_SUCCESS: return 'Выполнено';
        break;
      case TaskState::TASK_DONE_TIME_FAIL: return 'Провалено';
        break;
      case TaskState::TASK_DONE_GAME_OVER: return 'Остановлено с игрой';
        break;
      case TaskState::TASK_DONE_BANNED: return 'Дисквалифицировано';
        break;
      case TaskState::TASK_DONE_SKIPPED: return 'Пропущено';
        break;
      case TaskState::TASK_DONE_ABANDONED: return 'Отменено';
        break;
      default: return 'неизвестно';
        break;
    }
  }

  /**
   * Проверяет, может ли команда пропустить задание.
   */
  public function canBeSkipped()
  {
    //Задание может быть пропущено только при всех следующих условиях:
    //- уже получена первая подсказка ИЛИ если подсказок в задании нет, но пришло время первой подсказки
    //- еще не начат ввод ответов
    //- задание уже начато
    //- задание еще не завершено
    //- задание не дисквалифицировано
    //- время на задание еще не закончилось
    return
           (
             ($this->usedTips->count() > 1)
             ||
             (
               ($this->Task->tips->count() <= 1)
               &&
               (Timing::isExpired($this->getTaskSpentTimeCurrent(), $this->Task->Game->time_per_tip*60, 0))
             )
           ) 
        && ($this->postedAnswers->count() == 0)
        && ($this->status >= TaskState::TASK_ACCEPTED)
        && ($this->status != TaskState::TASK_CHEAT_FOUND)
        && ($this->status < TaskState::TASK_DONE)
        && ( ! Timing::isExpired($this->getTaskSpentTimeCurrent(), $this->Task->time_per_task_local*60, 0));
  }

  /**
   * Возвращает отпущенное на задание время с учетом всех текущих корректировок.
   *
   * @return  integer
   */
  public function getActualTimePerTask()
  {
    return $this->Task->time_per_task_local * 60;
  }

  /**
   * Возвращает израсходованное на задание время.
   * Основа для проверки на исчерпание времени!
   * Всегда возвращает значение не превышающее максимально отпущенного на задание времени.
   * 
   * @return  integer
   */
  public function getTaskSpentTimeCurrent()
  {
    // Если завершилось, то можно прямо из БД
    if ($this->status >= TaskState::TASK_DONE)
    {
      return $this->task_time_spent;
    }
    $res = ($this->accepted_at > 0)
        ? (time() - $this->accepted_at - $this->getActualTaskIdleTime())
        : 0;
    return ($res < $this->getActualTimePerTask())
        ? $res
        : $this->getActualTimePerTask();
  }

  /**
   * Возвращает время окончания задания с учетом всех корректировок.
   * Только для справок!
   *
   * @return  integer
   */
  public function getTaskStopTime()
  {
    return ($this->accepted_at > 0)
        ? ($this->accepted_at + $this->getActualTimePerTask() + $this->getActualTaskIdleTime())
        : 0;
  }

  /**
   * Возвращает время простоя задания.
   *
   * @return  integer
   */
  public function getActualTaskIdleTime()
  {
    return ($this->Task->Game->teams_can_update) ? 0 : $this->task_idle_time;
  }
  
  /**
   * Возвращает результаты задания в виде массива:
   * - ключи:
   *    - 'points' - набранные очки
   *    - 'time' - затраченное время
   * - данные - соответствущие значения
   */
  public function getTaskResults()
  {
    $res = array();
    $res['time'] = 0;
    $res['points'] = 0;
    switch ($this->status)
    {
      case (TaskState::TASK_DONE_SUCCESS):
        $res['points'] = 1;
      case (TaskState::TASK_DONE_TIME_FAIL):
      case (TaskState::TASK_DONE_SKIPPED):
      case (TaskState::TASK_DONE_BANNED):
        $res['time'] = $this->getTaskSpentTimeCurrent();
        break;
      //Остальные состояния на итоги не влияют.
      default:
        break;
    }
    return $res;
  }

  /**
   * Проверяет, можно ли начать задание.
   *
   * @return  boolean
   */
  public function canBeStarted()
  {
    if ($this->Task->manual_start)
    {
      return false;
    }
    if ($this->Task->max_teams == 0)
    {
      return true;
    }
    if ($activeTaskStates = $this->Task->getActiveTaskStates())
    {
      return ($activeTaskStates->count() < $this->Task->max_teams);
    }
    return true;
  }

  /**
   * Проверяет, можно ли сейчас вводить ответы.
   *
   * @return  boolean
   */
  public function canAcceptAnswers()
  {
    return $this->status == TaskState::TASK_ACCEPTED;
  }

  /**
   * Возвращает список ответов, которые предстоит ввести
   * 
   * @return Doctrine_Collection<Answer>
   */
  public function getRestAnswers()
  {
    $res = new Doctrine_Collection("Answer");
    //Построим индекс ответов $accceptedAnswersIndex с признаком того, что они приняты:
    $targetAnswers = $this->Task->getTargetAnswersForTeam($this->TeamState->Team);
    $acceptedAnswersIndex = array();
    foreach ($targetAnswers as $answer)
    {
      $acceptedAnswersIndex[$answer->id] = false;
    }
    foreach ($this->getPostedAnswersByStatus(PostedAnswer::ANSWER_OK) as $postedAnswer)
    {
      $acceptedAnswersIndex[$postedAnswer->answer_id] = true;
    }
    foreach ($targetAnswers as $answer)
    {
      if ( ! $acceptedAnswersIndex[$answer->id])
      {
        $res->add($answer);
      }
    }
    return $res;
  }
  
  /**
   * Возвращает список введенных правильных ответов.
   * 
   * @return Doctrine_Collection<PostedAnswer>
   */
  public function getGoodPostedAnswers()
  {
    return $this->getPostedAnswersByStatus(PostedAnswer::ANSWER_OK);
  }
  
  /**
   * Возвращает список введенных ответов, ожидающих проверки.
   * 
   * @return Doctrine_Collection<PostedAnswer>
   */
  public function getBeingVerifiedPostedAnswers()
  {
    return $this->getPostedAnswersByStatus(PostedAnswer::ANSWER_POSTED);
  }
  
  /**
   * Возвращает список введенных неверных ответов.
   * 
   * @return Doctrine_Collection<PostedAnswer>
   */
  public function getBadPostedAnswers()
  {
    return $this->getPostedAnswersByStatus(PostedAnswer::ANSWER_BAD);
  }
  
// Action

  /**
   * Обновляет состояние задания (сохраняет в БД).
   *
   * @param   WebUser   $actor  Исполнитель
   */
  public function updateState(WebUser $actor)
  {
    $time = time();
    if (!Timing::isExpired($time, Game::MIN_UPDATE_INERVAL, $this->task_last_update)
        || !$this->Task->Game->isActive())
    {
      return true;
    }
    
    if (!$this->canUpdateState($actor))
    {
      return Utils::cannotMessage($actor->login, 'обновлять состояние задания');
    }

    /* Прежде чем заниматься расчетами, проверим состояние задания на устаревание */
    if (($this->status >= TaskState::TASK_ACCEPTED)
        &&
        ($this->status < TaskState::TASK_DONE)
        &&
        ( ! $this->TeamState->Game->teams_can_update)
        &&
        (Timing::isExpired($time, $this->TeamState->Game->update_interval_max, $this->task_last_update)))
    {
      $this->task_idle_time += $time - $this->task_last_update - $this->TeamState->Game->update_interval_max;
      $this->save();
    }
    
    switch ($this->status)
    {
      // Задание назначено, но ему еще надо разрешить стартовать.
      case TaskState::TASK_GIVEN:
        // Если задание можно начинать, то начнем.
        if ($this->canBeStarted())
        {
          $this->start($actor);
        }
        break;

      // Заданию дан старт, но команда его еще не увидела.
      case TaskState::TASK_STARTED:
        // В режиме нагрузочного тестирования задание считается прочитанным сразу после старта
        if (Utils::LOAD_TEST_MODE)
        {
          $this->accept($actor);
        }
        break;

      // Команда уже ознакомилась с заданием и выполняет его.
      case TaskState::TASK_ACCEPTED:
        // Обновим состояние полученных ответов.
        $this->processPostedAnswers();
        // Обновим состояние подсказок.
        $this->updateTips();

        if ($this->checkCheat())
        {
          $this->status = TaskState::TASK_CHEAT_FOUND;
        }
        else
        {
          // Проверим различные признаки завершения задания:
          // ...по исчерпанию времени на задание.
          $timeFailTime = $this->checkTimeFail();
          // ...в результате принудительного завершения игры.
          // ...или в результате исчерпания игрового времени команды.
          $gameOverTime = $this->checkGameOver();
          // ...по получению необходимых ответов.
          $succedTime = $this->checkTargets();
          
          if ($succedTime > 0)
          {
            //Задание сделали, надо проверить, успели ли вовремя. 
            if (($timeFailTime > 0) && ($gameOverTime > 0))
            {
              if (($succedTime < $timeFailTime) && ($succedTime < $gameOverTime))
              {
                //Задание завершено успешно
                $this->doneSuccess($actor);
              }
              else
              {
                //Незачет.
                $succedTime = 0;
              }
            }
            elseif ($timeFailTime > 0)
            {
              if ($succedTime < $timeFailTime)
              {
                //Задание завершено успешно
                $this->doneSuccess($actor);
              }
              else
              {
                //Незачет.
                $succedTime = 0;
              }
            }
            elseif ($gameOverTime > 0)
            {
              if ($succedTime < $gameOverTime)
              {
                //Задание завершено успешно
                $this->doneSuccess($actor);
              }
              else
              {
                //Незачет.
                $succedTime = 0;
              }
            }            
            else //ни задание, ни игра не закончились.
            {
              //Задание завершено успешно
              $this->doneSuccess($actor);
            }
          }
          
          if ($succedTime == 0)
          {
            //Задание не сделали, проверим признаки просрочки
            if (($timeFailTime > 0) && ($gameOverTime > 0))
            {
              if ($timeFailTime < $gameOverTime)
              {
                //Исчерпано время задния.
                $this->doneTimeFail($actor);  
              }
              else
              {
                //Исчерпано время игры.
                $this->doneGameOver($actor);
              }
            }
            elseif ($timeFailTime > 0)
            {
              //Исчерпано время задания.
              $this->doneTimeFail($actor);
            }
            elseif ($gameOverTime > 0)
            {
              //Исчерпано время игры.
              $this->doneGameOver($actor);
            }
            //else - ни задание, ни игра не закончились.
          }
        }
        break;

      //Ранее было обнаружено нарушение правил задания.
      case TaskState::TASK_CHEAT_FOUND:
        // Обновим состояние полученных ответов
        $this->processPostedAnswers();
        // Перепроверим состояние нарушения и отменим при необходимости.
        if (!$this->checkCheat())
        {
          $this->status = TaskState::TASK_ACCEPTED;
        }
        else
        {
          $this->task_time_spent = $this->getTaskSpentTimeCurrent();
          // Если время первой подсказки по умолчанию прошло, то закроем задание.
          // Также закроем если исчерпано время задания или игра завершена.
          if (($this->task_time_spent >= $this->TeamState->Game->time_per_tip * 60)
              || $this->checkTimeFail()
              || $this->checkGameOver())
          {
            $this->donePenalty($actor);
          }
        }
        break;

      // Прочие состояния особых действий не требуют.
      default:
        break;
    }
    $this->task_last_update = time();
    $this->save();

    return true;
  }

  /**
   * Разрешает старт задания.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function start(WebUser $actor)
  {
    if (!$this->canUpdateState($actor))
    {
      return Utils::cannotMessage($actor->login, 'обновлять состояние задания');
    }
    //Если задание заполнено, или требует ручного старта, то дать старт может только руководитель
    if ($this->Task->isFilled() || $this->Task->manual_start)
    {
      if (!$this->canBeManaged($actor))
      {
        return Utils::cannotMessage($actor->login, Permission::byId(Permission::GAME_MODER)->description);
      }
    }
    if ($this->status >= TaskState::TASK_DONE)
    {
      return 'Команда '.$this->TeamState->Team->name.' уже завершила задание '.$this->Task->name;
    }
    if ($this->status > TaskState::TASK_GIVEN)
    {
      return 'Команда '.$this->TeamState->Team->name.' не может повторно начать задание '.$this->Task->name;
    }
    $this->status = TaskState::TASK_STARTED;
    $this->started_at = time();
    $this->accepted_at = 0;
    $this->done_at = 0;
    $this->task_time_spent = 0;

    $this->updateTips();

    $this->task_last_update = time();
  }

  /**
   * Подтверждает факт отображения задания.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function accept(WebUser $actor)
  {
    // canBeObserved - так как подтверждение просмотра выполняется от лица команды.
    if (!$this->canBeObserved($actor))
    {
      return Utils::cannotMessage($actor->login, Permission::byId(Permission::TEAM_MODER)->description);
    }
    if ($this->status >= TaskState::TASK_ACCEPTED)
    {
      return 'Команда '.$this->TeamState->Team->name.' уже ознакомилась с заданием '.$this->Task->name;
    }

    $this->status = TaskState::TASK_ACCEPTED;
    $this->accepted_at = time();
    $this->done_at = 0;
    $this->task_time_spent = 0;
    $this->updateTips();

    $this->task_last_update = time();
  }

  /**
   * Подтверждает факт успешного выполнения задания.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function doneSuccess(WebUser $actor)
  {
    if (!$this->canUpdateState($actor))
    {
      return Utils::cannotMessage($actor->login, 'обновлять состояние задания');
    }
    if ($this->status <= TaskState::TASK_STARTED)
    {
      return 'Команда '.$this->TeamState->Team->name.' еще не ознакомилась с заданием '.$this->Task->name;
    }
    if ($this->status >= TaskState::TASK_DONE)
    {
      return 'Команда '.$this->TeamState->Team->name.' уже завершила задание '.$this->Task->name;
    }

    // Длительность задания - от старта до последнего правильного кода.
    $this->processPostedAnswers();
    $doneTime = $this->checkTargets(); //TODO: Повторный вызов, сразу перед вызовом doneSuccess() уже был вызов checkTargets()
    // Если ни одного кода нет, но задание нужно завершить,
    // тогда завершаем его по времени последнего обновления.
    if ($doneTime <= 0)
    {
      $doneTime = ($this->accepted_at > $this->task_last_update)
          ? $this->accepted_at
          : $this->task_last_update;
    }

    $this->task_time_spent = $doneTime - $this->accepted_at - $this->getActualTaskIdleTime();
    $this->done_at = $doneTime;
    $this->status = TaskState::TASK_DONE_SUCCESS;

    $this->task_last_update = time();
  }

  /**
   * Подтверждает факт исчерпания времени на задание.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function doneTimeFail(WebUser $actor)
  {
    if (!$this->canUpdateState($actor))
    {
      return Utils::cannotMessage($actor->login, 'обновлять состояние задания');
    }
    if ($this->status <= TaskState::TASK_STARTED)
    {
      return 'Команда '.$this->TeamState->Team->name.' еще не ознакомилась с заданием '.$this->Task->name;
    }
    if ($this->status >= TaskState::TASK_DONE)
    {
      return 'Команда '.$this->TeamState->Team->name.' уже завершила задание '.$this->Task->name;
    }

    $this->task_time_spent = $this->getTaskSpentTimeCurrent();
    $this->done_at = time();
    $this->status = TaskState::TASK_DONE_TIME_FAIL;

    $this->task_last_update = time();
  }

  /**
   * Пропускает задание.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function doneSkip(WebUser $actor)
  {
    if (!$this->canUpdateState($actor)
        && !$this->TeamState->Team->canBeManaged($actor))
    {
      return Utils::cannotMessage($actor->login, 'чтобы отказаться от выполнения задания');
    }
    //Руководитель игры может пропустить задание в любом случае, остальные по условиям
    if (!$this->TeamState->Game->canBeManaged($actor)
        && !$this->canBeSkipped())
    {
      return 'Команда '.$this->TeamState->Team->name.' не может сейчас отказаться от выполнения задания '.$this->Task->name;
    }

    $this->task_time_spent = $this->getTaskSpentTimeCurrent();
    $this->done_at = time();
    $this->status = TaskState::TASK_DONE_SKIPPED;

    $this->task_last_update = time();
  }

  /**
   * Подтверждает факт исчерпания времени на игру.
   * Задание закрывается из любого состояния.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function doneGameOver(WebUser $actor)
  {
    if (!$this->canUpdateState($actor))
    {
      return Utils::cannotMessage($actor->login, 'обновлять состояние задания');
    }
    if ($this->status <= TaskState::TASK_STARTED)
    {
      return 'Команда '.$this->TeamState->Team->name.' еще не ознакомилась с заданием '.$this->Task->name;
    }
    if ($this->status >= TaskState::TASK_DONE)
    {
      return 'Команда '.$this->TeamState->Team->name.' уже завершила задание '.$this->Task->name;
    }

    $this->task_time_spent = $this->getTaskSpentTimeCurrent();
    $this->done_at = time();
    $this->status = TaskState::TASK_DONE_GAME_OVER;

    $this->task_last_update = time();
  }

  /**
   * Подтверждает факт дисквалификации задания.
   * ВНИМАНИЕ: Не сохраняет данные в БД, save() выполняет вызывающий.
   *
   * @param   WebUser   $actor  Исполнитель
   * @return  mixed             True при успехе, иначе строка с ошибкой.
   */
  public function donePenalty(WebUser $actor)
  {
    if (!$this->canUpdateState($actor))
    {
      return Utils::cannotMessage($actor->login, 'обновлять состояние задания');
    }
    if ($this->status <= TaskState::TASK_STARTED)
    {
      return 'Команда '.$this->TeamState->Team->name.' еще не ознакомилась с заданием '.$this->Task->name;
    }
    if ($this->status >= TaskState::TASK_DONE)
    {
      return 'Команда '.$this->TeamState->Team->name.' уже завершила задание '.$this->Task->name;
    }

    // В любом случае нужно начислить времени не меньше, чем на подсказку по умолчанию.
    $this->task_time_spent = ($this->getTaskSpentTimeCurrent() > $this->Task->Game->time_per_tip * 60)
        ? $this->getTaskSpentTimeCurrent()
        : $this->Task->Game->time_per_tip * 60;
    $this->done_at = time();
    $this->status = TaskState::TASK_DONE_BANNED;

    $this->task_last_update = time();
  }

	/**
	 * Возвращает имя CSS-класса для индикации состояния.
	 *
	 * @return  string
	 */
	public function getHighlightClass()
	{
		$class = '';
		switch ($this->status)
		{
			case TaskState::TASK_GIVEN:
			case TaskState::TASK_STARTED:
			case TaskState::TASK_ACCEPTED:
				break;
			case TaskState::TASK_CHEAT_FOUND:
				$class = 'danger';
				break;
			case TaskState::TASK_DONE:
			case TaskState::TASK_DONE_SUCCESS:
				$class = 'info';
				break;
			case TaskState::TASK_DONE_TIME_FAIL:
			case TaskState::TASK_DONE_SKIPPED:
			case TaskState::TASK_DONE_GAME_OVER:
				$class = 'warn';
				break;
			case TaskState::TASK_DONE_BANNED:
			case TaskState::TASK_DONE_ABANDONED:
				$class = 'danger';
				break;
		}
		return $class;
	}

  /**
   * Разбирает строку на отдельные ответы (по пробелам) и помещает их в очередь проверки.
   *
   * @param   srting    $answers  Строка с ответами
   * @param   WebUser   $actor    Отправляющий коды
   * @return  mixed               True при удаче, строка с ошибкой в случае проблем.
   */
  public function postAnswers($answers, WebUser $actor)
  {
    if (!$this->TeamState->Team->isPlayer($actor)
        && !$this->canBeManaged($actor))
    {
      return 'Отправлять коды могут только участники команды или организаторы игры.';
    }
    if ($this->status != TaskState::TASK_ACCEPTED)
    {
      return 'Отправлять коды можно только после старта задания до его завершения, и когда оно не дисквалифицировано.';
    }

    $sourceAnswers = explode(' ', trim($answers));
    //В строке могут быть одинаковые коды, их надо отфильтровать,
    //иначе будет сбой БД при записи. Почему-то этого не предотвращает даже
    //поштучная запись ответов, реализованная в postAnswer.
    //Поэтому отфильтруем значения.
    $sourceAnswers = array_unique($sourceAnswers);

    $timeForAll = time();
    foreach ($sourceAnswers as $answer)
    {
      $cleanAnswer = trim($answer);
      if ($cleanAnswer !== '')
      {
        $this->postAnswer($cleanAnswer, $timeForAll, $actor);
      }
    }
  }

  //// Self ////

	/**
	 * Проверяет, не было ли обработано такое значение ответа ранее.
	 * 
	 * @param   string  $answerValue
	 * @return  boolean
	 */
	protected function isKnownAnswerValue($answerValue)
	{
		foreach ($this->postedAnswers as $postedAnswer)
		{
			if (Utils::mb_strcasecmp(trim($postedAnswer->value), trim($answerValue)))
			{
				return true;
			}
		}
		return false;
	}

  /**
   * Ищет указанный ответ среди проверенных.
   * 
   * @param   string        $answerValue
   * 
   * @return  PostedAnswer  Или false, если не найдено
   */
  protected function findPostedAnswerFor(Answer $answer)
  {
    foreach ($this->postedAnswers as $postedAnswer)
    {
      if ($postedAnswer->answer_id == $answer->id)
      {
        return $postedAnswer;
      }
    }
    return false;    
  }

  /**
   * Проверяет, была ли подсказка уже назначена
   * @param   Tip   $tip  Подсказка на проверку
   * @return  boolean
   */
  protected function isKnownTip(Tip $tip)
  {
    foreach ($this->usedTips as $usedTip)
    {
      if ($usedTip->tip_id == $tip->id)
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Помещает в очередь проверки один ответ.
   *
   * @param   string    $answerValue
   * @param   string    $timestamp    Дата отправки ответа, которую нужно назначить.
   * @param   WebUser   $poster       Игрок, который отправил код.
   */
  protected function postAnswer($answerValue, $timestamp, WebUser $poster)
  {
    $cleanValue = trim($answerValue);
    if ($this->isKnownAnswerValue($answerValue))
    {
      return;
    }
    $newPostedAnswer = new PostedAnswer;
    $newPostedAnswer->task_state_id = $this->id;
    $newPostedAnswer->value = $cleanValue;
    $newPostedAnswer->post_time = $timestamp;
    $newPostedAnswer->web_user_id = $poster->id;
    $newPostedAnswer->status = PostedAnswer::ANSWER_POSTED;
	$newPostedAnswer->save();
  }

  /**
   * Перепроверяет имеющиеся ответы, маркирует их верными и неверными.
   * Возвращает время (Unix) ввода наиболее позднего правильного ответа.
   * Внимание! Не сохраняет изменения в БД, save выполняет вызывающий.
   *
   * @return  integer
   */
  protected function processPostedAnswers()
  {
    /* Возможна ситуация, когда в результате редактирования ответов в
     * процессе игры часть уже введенных ответов может изменить свой
     * статус: неверные могут стать верными наоборот.
     * Поэтому перепроверяем все известные ответы (время их ввода не меняется!).
     */
    $lastGoodTime = $this->accepted_at;
    $actualAnswers = $this->Task->getTargetAnswersForTeam($this->TeamState->Team);
    foreach ($this->postedAnswers as $postedAnswer)
    {
      $answer = Task::answerForValue($postedAnswer->value, $actualAnswers);
      if (!$answer)
      {
        $postedAnswer->status = PostedAnswer::ANSWER_BAD;
        $postedAnswer->Answer = null;
      }
      else
      {
        $postedAnswer->status = PostedAnswer::ANSWER_OK;
        $postedAnswer->Answer = $answer;
        if ($lastGoodTime <= $postedAnswer->post_time)
        {
          $lastGoodTime = $postedAnswer->post_time;
        }
      }
    }
    return $lastGoodTime;
  }

  /**
   * Проверяет признаки завершения игры.
   * Если игра завершена, возвращает момент времени когда это произошло, иначе 0.
   */
  protected function checkGameOver()
  {
    // Варианты окончания игры (достаточно любого):
    // - игра уже остановлена
    if ($this->TeamState->Game->status >= Game::GAME_FINISHED)
    {
      return $this->TeamState->Game->finished_at;
    }

    // - исчерпано время выделенное команде на игру
    elseif ($this->TeamState->getTeamStopTime() < time())
    {
      return $this->TeamState->getTeamStopTime();
    }

    // - прошло время принудительной остановки игры
    elseif ($this->TeamState->Game->getGameStopTime() < time())
    {
      return $this->TeamState->Game->getGameStopTime();
    }
    else
    {
      return 0;
    }
  }

  /**
   * Проверяет признаки нарушения правил задания.
   *
   * @return  boolean
   */
  protected function checkCheat()
  {
    $badAnswers = 0;
    foreach ($this->postedAnswers as $postedAnswer)
    {
      if ($postedAnswer->status == PostedAnswer::ANSWER_BAD)
      {
        $badAnswers++;
      }
    }
    return $badAnswers > $this->Task->try_count_local;
  }

  /**
   * Проверяет, не вышло ли время, отпущенное на задание.
   * Если вышло, возвращает момент времени когда это произошло, иначе 0.
   *
   * @return boolean
   */
  protected function checkTimeFail()
  {
    if ($this->started_at == 0)
    {
      return 0;
    }
    // Реально здесь только на "равно" сработает,
    // так как getTaskSpentTimeCurrent не вернет больше, чем может длиться задание
    return ($this->getTaskSpentTimeCurrent() >= $this->getActualTimePerTask())
        ? $this->started_at + $this->getActualTimePerTask()
        : 0;
  }

  /**
   * Проверяет признаки завершения задания.
   * Возвращает веремя успешного завершения задания
   * или 0, если задание не выполнено.
   *
   * @return integer
   */
  protected function checkTargets()
  {
    if ($this->status == TaskState::TASK_CHEAT_FOUND)
    {
      return false;
    }
    $answersAvailableForTeam = $this->Task->getTargetAnswersForTeam($this->TeamState->Team)->count();
    if ($this->Task->min_answers_to_success == 0)
    {
      $answersRequired = $answersAvailableForTeam;
    }
    else
    {
      $answersRequired = ($answersAvailableForTeam < $this->Task->min_answers_to_success)
          ? $answersAvailableForTeam
          : $this->Task->min_answers_to_success;
    }
    $goodAnswers = array();
    foreach ($this->postedAnswers as $postedAnswer)
    {
      if ($postedAnswer->status == PostedAnswer::ANSWER_OK)
      {
        array_push($goodAnswers, $postedAnswer->post_time);
      }
    }
    sort($goodAnswers);
    if (   (count($goodAnswers) == 0)
        || (count($goodAnswers) < $answersRequired))
    {
      return 0;
    }
    for ($index = 0; $index < count($goodAnswers); $index++)
    {
      if ($index == ($answersRequired - 1))
      {
        return $goodAnswers[$index];
      }      
    }
  }

  /**
   * Обновляет состояние подсказок, выдает автоматические.
   * Внимание! Не сохраняет изменения в БД, save выполняет вызывающий.
   * 
   * @return boolean
   */
  protected function updateTips()
  {
    foreach ($this->Task->tips as $tip)
    {
      if (!$this->isKnownTip($tip))
      {
        if ($tip->answer_id > 0)
        {
          if ($postedAnswer = $this->findPostedAnswerFor($tip->Answer))
          {
            $new = new UsedTip();
            $new->tip_id = $tip->id;
            $new->task_state_id = $this->id;
            $new->status = UsedTip::TIP_USED;
            $new->used_since = $postedAnswer->post_time;
            $this->usedTips->add($new);
          }
        }
        elseif ((($tip->delay == 0) || ($this->getTaskSpentTimeCurrent() >= ($tip->delay * 60)))
                && ($tip->answer_id <= 0)) //Подсказка после кода выдается только с кодом.
        {
          $new = new UsedTip();
          $new->tip_id = $tip->id;
          $new->task_state_id = $this->id;
          $new->status = UsedTip::TIP_USED;
          $new->used_since = ($this->started_at > $this->accepted_at)
              ? $this->started_at + $tip->delay * 60
              : $this->accepted_at + $tip->delay * 60;
          $this->usedTips->add($new);
        }
      }
    }
  }
 
  /**
   * Возвращает список введенных ответов с указанным статусом.
   * 
   * @param  integer              $status
   * 
   * @return Doctrine_Collection 
   */
  protected function getPostedAnswersByStatus($status)
  {
    $res = new Doctrine_Collection("PostedAnswer");
    foreach ($this->postedAnswers as $postedAnswer)
    {
      if ($postedAnswer->status == $status)
      {
        $res->add($postedAnswer);
      }
    }
    return $res;
  }
}