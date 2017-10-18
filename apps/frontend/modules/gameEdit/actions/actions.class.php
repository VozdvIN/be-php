<?php
class gameEditActions extends MyActions
{
	public function preExecute()
	{
		parent::preExecute();
	}

	public function executePromo(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}

	public function executePromoEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->form = new GameFormPromo($this->game);
	}

	public function executePromoUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->form = new GameFormPromo($this->game);
		$this->processForm($request, $this->form, 'gameEdit/promo?id='.$this->game->id);
		$this->setTemplate('promoEdit');
	}

	public function executeTeams($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
		$this->_canManage = $this->_game->isManager($this->sessionWebUser) || $this->_isModerator;
		$this->_teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')->innerJoin('ts.Team')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('ts.Team.name')->execute();
	}

	public function executeSettings($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}

	public function executeSettingsEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->form = new GameFormSettings($this->game);
	}

	public function executeSettingsUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->form = new GameFormSettings($this->game);
		$this->processForm($request, $this->form, 'gameEdit/settings?id='.$this->game->id);
		$this->setTemplate('settingsEdit');
	}

	public function executeTemplates($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}

	public function executeTemplatesEdit(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->form = new GameFormTemplates($this->game);
	}

	public function executeTemplatesUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->form = new GameFormTemplates($this->game);
		$this->processForm($request, $this->form, 'gameEdit/templates?id='.$this->game->id);
		$this->setTemplate('templatesEdit');
	}

	public function executeTasks($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_canManage = $this->_game->isManager($this->sessionWebUser);
		$this->_isModerator = $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
		$this->_tasks = Doctrine::getTable('Task')
			->createQuery('t')->leftJoin('t.answers')->leftJoin('t.taskConstraints')->leftJoin('t.taskTransitions')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('t.name')->execute();
	}

	public function executeTasksWeights($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_tasks = Doctrine::getTable('Task')
			->createQuery('t')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('t.name')->execute();
	}

	public function executeTasksConstraints($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_tasks = Doctrine::getTable('Task')
			->createQuery('t')->leftJoin('t.taskConstraints')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('t.name')->execute();
	}

	public function executeTasksTransitions($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser) || $this->_game->isActor($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игру')
		);

		$this->_tasks = Doctrine::getTable('Task')
			->createQuery('t')->leftJoin('t.taskTransitions')
			->select()->where('game_id = ?', $this->_game->id)
			->orderBy('t.name')->execute();
	}

	//TODO: Заменить форму, UPD: на какую именно?
	public function executeNew(sfWebRequest $request)
	{
		$this->errorRedirectUnless(
			Game::isModerator($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'создавать игру')
		);

		$this->form = new GameFormPromo();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->errorRedirectUnless(
			Game::isModerator($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'создавать игру')
		);

		$this->form = new GameFormPromo();
		$this->processForm($request, $this->form, 'game/index');
		$this->setTemplate('new');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::DELETE));
		$request->checkCSRFProtection();
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectUnless(
			$this->game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage($this->sessionWebUser->login, 'удалять игру')
		);

		$this->game->delete();
		$this->successRedirect('Игра успешно удалена.', 'game/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form, $redirectUrl)
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
			if ((Timing::strToDate($object->stop_datetime) - Timing::strToDate($object->start_datetime)) < $object->time_per_game*60)
			{
				$this->errorMessage('Сохранить игру не удалось. Даты начала и остановки игры должны отстоять друг от друга не менее, чем на отведенное на игру время.');
			}
			else
			{
				$object->initDefaults();
				$object->save();
				$this->successRedirect('Игра '.$object->name.' успешно сохранена.', $redirectUrl);
			}
		}
		else
		{
			$this->errorMessage('Сохранить игру не удалось. Исправьте ошибки и попробуйте снова.');
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

			$this->successRedirect(
				'Отменена заявка команды '.$this->team->name.' на игру '.$this->game->name.'.',
				'gameEdit/teams?id='.$this->game->id
			);
		}
	}

	public function executeRegister(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');

		$this->_teams = Team::all();

		$this->errorRedirectIf(
			$this->_teams->count() == 0,
			'Нет команд, которые вы можете зарегистрировать.',
			'gameEdit/showTeams?id='.$this->_game->id
		);
	}

	public function executeRegisterDo(sfWebRequest $request)
	{
		$this->decodeArgs($request);

		if (is_string($res = $this->game->registerTeam($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось зарегистрировать команду '.$this->team->name.' на игру '.$this->game->name.': '.$res);
		}
		else
		{
			Utils::sendNotifyGroup(
				'Команда '.$this->team->name.' зарегистрирована на игру '.$this->game->name,
				'Ваша команда "'.$this->team->name.'" зарегистрирована на игру "'.$this->game->name.'".',
				$this->team->getLeadersRaw()
			);

			$this->successRedirect(
				'Команда '.$this->team->name.' зарегистрирована на игру '.$this->game->name.'.',
				'gameEdit/teams?id='.$this->game->id
			);
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

			$this->successRedirect(
				'Команда '.$this->team->name.' снята с игры '.$this->game->name.'.',
				'gameEdit/teams?id='.$this->game->id
			);
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
