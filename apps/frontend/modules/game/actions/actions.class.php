<?php
class gameActions extends MyActions
{

	public function preExecute()
	{
		parent::preExecute();
		$this->retUrl = $this->retUrlRaw;
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->errorRedirectIf(
			$this->sessionWebUser->cannot(Permission::GAME_INDEX, 0),
			Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список игр')
		);

		$this->_currentRegion = Region::byIdSafe($this->session->getAttribute('region_id'));

		$this->_retUrlRaw = Utils::encodeSafeUrl('game/index');

		$this->_games = Game::byRegion($this->_currentRegion);
	}

	public function executeIndexActive(sfWebRequest $request)
	{
		$this->errorRedirectIf(
			$this->sessionWebUser->cannot(Permission::GAME_INDEX, 0),
			Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список игр')
		);
		$this->_retUrlRaw = Utils::encodeSafeUrl('game/index');
		$this->_games = Game::getGamesActive(Region::byIdSafe($this->session->getAttribute('region_id')));
	}

	public function executeIndexAnnounced(sfWebRequest $request)
	{
		$this->errorRedirectIf(
			$this->sessionWebUser->cannot(Permission::GAME_INDEX, 0),
			Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список игр')
		);
		$this->_retUrlRaw = Utils::encodeSafeUrl('game/index');
		$this->_games = Game::getGamesForAnnounce(Region::byIdSafe($this->session->getAttribute('region_id')));
	}

	public function executeIndexArchived(sfWebRequest $request)
	{
		$this->errorRedirectIf(
			$this->sessionWebUser->cannot(Permission::GAME_INDEX, 0),
			Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список игр')
		);
		$this->_retUrlRaw = Utils::encodeSafeUrl('game/index');
		$this->_games = Game::getGamesArchived(Region::byIdSafe($this->session->getAttribute('region_id')));
	}

	public function executePromo(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		if ( ! $this->_game->canBeObserved($this->sessionWebUser))
		{
			$this->forward('game', 'info');
		}
		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}
	
	public function executePromoEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless($this->game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру'));
		$this->form = new GameFormPromo($this->game);
	}
	
	public function executePromoUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->form = new GameFormPromo($this->game);
		$this->processForm($request, $this->form, 'game/promo?id='.$this->game->id);
		$this->setTemplate('promoEdit');
	}
		
	public function executeTeams($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		if ( ! $this->_game->canBeObserved($this->sessionWebUser))
		{
			$this->forward('game', 'info');
		}
		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);

		$this->_teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')->innerJoin('ts.Team')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('ts.Team.name')->execute();
		$this->_gameCandidates = Doctrine::getTable('GameCandidate')
			->createQuery('gc')->innerJoin('gc.Team')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('gc.Team.name')->execute();
	}

	public function executeSettings($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		if ( ! $this->_game->canBeObserved($this->sessionWebUser))
		{
			$this->forward('game', 'info');
		}
		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}
	
	public function executeSettingsEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless($this->game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру'));
		$this->form = new GameFormSettings($this->game);
	}
		
	public function executeSettingsUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->form = new GameFormSettings($this->game);
		$this->processForm($request, $this->form, 'game/settings?id='.$this->game->id);
		$this->setTemplate('settingsEdit');
	}
	
	public function executeTemplates($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		if ( ! $this->_game->canBeObserved($this->sessionWebUser))
		{
			$this->forward('game', 'info');
		}
		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}
	
	public function executeTemplatesEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless($this->game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру'));
		$this->form = new GameFormTemplates($this->game);
	}
		
	public function executeTemplatesUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->form = new GameFormTemplates($this->game);
		$this->processForm($request, $this->form, 'game/templates?id='.$this->game->id);
		$this->setTemplate('templatesEdit');
	}
	
	public function executeTasks($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		if ( ! $this->_game->canBeObserved($this->sessionWebUser))
		{
			$this->forward('game', 'info');
		}
		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);

		$this->_tasks = Doctrine::getTable('Task')
			->createQuery('t')->leftJoin('t.answers')->leftJoin('t.taskConstraints')->leftJoin('t.taskTransitions')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('t.name')->execute();
	}

	//TODO: Заменить форму
	public function executeNew(sfWebRequest $request)
	{
		$this->errorRedirectUnless(Game::isModerator($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'создавать игру'));
		$this->form = new GameFormPromo();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->errorRedirectUnless(Game::isModerator($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'создавать игру'));
		$this->form = new GameFormPromo();
		$this->processForm($request, $this->form, 'game/index');
		$this->setTemplate('new');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::DELETE));
		$request->checkCSRFProtection();
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(Game::isModerator($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'удалять игру'));
		$this->game->delete();
		$this->successRedirect('Игра успешно удалена.', 'game/index');
	}

	//TODO: Deprecated
	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless($this->game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру'));
		$this->form = new GameForm($this->game);
	}

	//TODO: Deprecated
	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->form = new GameForm($this->game);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, /*string*/ $successRetUrl)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

		if ($form->isValid())
		{
			$object = $form->updateObject();
			$this->errorRedirectUnless($object->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'изменять игру'));
			if ( ! (    (Timing::strToDate($object->start_briefing_datetime) <= Timing::strToDate($object->start_datetime))
					 && (Timing::strToDate($object->start_datetime) <= Timing::strToDate($object->stop_datetime))
					 && (Timing::strToDate($object->stop_datetime) <= Timing::strToDate($object->finish_briefing_datetime)) ) )
			{
				$this->errorMessage('Сохранить игру не удалось. Даты брифинга, начала, остановки, и подведения итогов игры стоят в неправильном порядке.');
			}
			if ( (Timing::strToDate($object->stop_datetime) - Timing::strToDate($object->start_datetime)) < $object->time_per_game*60 )
			{
				$this->errorMessage('Сохранить игру не удалось. Даты начала и остановки игры должны отстоять друг от друга не менее, чем на отведенное на игру время.');
			}
			else
			{
				$object->initDefaults();
				$object->save();
				$this->successRedirect('Игра '.$object->name.' успешно сохранена.', $successRetUrl);
			}
		}
		else
		{
			$this->errorMessage('Сохранить игру не удалось. Исправьте ошибки и попробуйте снова.');
		}
	}

	public function executeInfo(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);		
		$teamList = $this->_game->getTeamsAvailableToPostJoinBy($this->sessionWebUser);
		$this->_canPostJoin = $teamList->count() > 0;
	}

	public function executePostJoinManual(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->retUrl = $this->retUrlRaw;

		$this->teamList = $this->game->getTeamsAvailableToPostJoinBy($this->sessionWebUser);
		$this->errorRedirectIf($this->teamList->count() <= 0, 'Нет команд, от лица которых Вы можете подать заявку на игру.');
	}

	public function executeAddTeamManual(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless($this->game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, ' регистрировать команды на игру'));
		$this->retUrl = $this->retUrlRaw;

		$this->teamList = new Doctrine_Collection('Team');
		foreach (Team::all() as $team)
		{
			if (   ( ! $this->game->isTeamRegistered($team))
				&& ( ! $this->game->isTeamCandidate($team))
				&& ($team->id != $this->game->team_id))
			{
				$this->teamList->add($team);
			}
		}
		
		$this->errorRedirectIf($this->teamList->count() <= 0, 'Нет команд, которые вы можете зарегистрировать.', Utils::decodeSafeUrl($this->retUrl));
	}

	public function executePostJoin(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->game->postJoin($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось подать заявку команды '.$this->team->name.' на игру '.$this->game->name.': '.$res);
		}
		else
		{
			if ($this->game->team_id > 0)
			{
				Utils::sendNotifyGroup(
					'Заявка '.$this->team->name.' на игру '.$this->game->name,
					'Команда "'.$this->team->name.'" подала заявку на вашу игру "'.$this->game->name.'".'."\n"
					.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/teams?id='.$this->game->id,
					$this->game->Team->getLeadersRaw()
				);
			}
			else
			{
				Utils::sendNotifyAdmin(
					'Заявка '.$this->team->name.' на игру '.$this->game->name,
					'Команда "'.$this->team->name.'" подала заявку на игру "'.$this->game->name.'", которой не назначена команда-организатор.'."\n"
					.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/teams?id='.$this->game->id
				);
			}

			$this->successRedirect('Заявка команды '.$this->team->name.' на игру '.$this->game->name.' принята.');
		}
	}

	public function executeCancelJoin(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->game->cancelJoin($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось отменить заявку команды '.$this->team->name.' на игру '.$this->game->name.': '.$res);
		}
		else
		{
			Utils::sendNotifyGroup(
				'Отклонена регистрация '.$this->team->name.' на игру '.$this->game->name,
				'Заявка вашей команды "'.$this->team->name.'" на участие в игре "'.$this->game->name.'" отклонена.',
				$this->team->getLeadersRaw()
			);

			$this->successRedirect('Отменена заявка команды '.$this->team->name.' на игру '.$this->game->name.'.');
		}
	}

	public function executeAddTeam(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		
		if (is_string($res = $this->game->registerTeam($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось зарегистрировать команду '.$this->team->name.' на игру '.$this->game->name.': '.$res);
		}
		else
		{
			Utils::sendNotifyGroup(
				'Регистрация '.$this->team->name.' на игру '.$this->game->name,
				'Ваша команда "'.$this->team->name.'" принята к участию в игре "'.$this->game->name.'"'."\n"
				.'Афиша игры: http://'.SiteSettings::SITE_DOMAIN.'/game/info?id='.$this->game->id,
				$this->team->getLeadersRaw()
			);      

			$this->successRedirect('Команда '.$this->team->name.' зарегистрирована на игру '.$this->game->name.'.');
		}
	}

	public function executeRemoveTeam(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->game->unregisterTeam($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось снять команду '.$this->team->name.' с игры '.$this->game->name.': '.$res);
		}
		else
		{
			Utils::sendNotifyGroup(
				'Команда '.$this->team->name.' снята с игры '.$this->game->name,
				'Ваша команда "'.$this->team->name.'" снята с игры "'.$this->game->name.'".',
				$this->team->getLeadersRaw()
			);

			$this->successRedirect('Команда '.$this->team->name.' снята с игры '.$this->game->name.'.');
		}
	}

	/**
	 * Раскодирует для не-"...manual" процедур web-параметры и пишет их в локальные свойства.
	 * Используются следующие параметры:
	 * - id     - ключ игры
	 * - teamId - ключ команды
	 *
	 * @param   sfWebRequest    $request  исходный запрос
	 */
	protected function decodeArgs(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->forward404Unless($this->team = Team::byId($request->getParameter('teamId')), 'Команда не найдена.');
	}

}
