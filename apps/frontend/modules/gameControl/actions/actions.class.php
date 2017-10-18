<?php

/**
 * Контроллер управления игрой.
 */
class gameControlActions extends MyActions
{

	public function executeState(sfRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeObserved($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'просматривать игру'
			)
		);

		$this->_isManager = $this->_game->canBeManaged($this->sessionWebUser);
	}

	public function executeTasks(sfRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeObserved($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'просматривать игру'
			)
		);

		$this->_teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')
			->select()
			->innerJoin('ts.Team')
			->leftJoin('ts.taskStates')
			->where('ts.game_id = ?', $this->_game->id)
			->orderBy('ts.Team.name, ts.taskStates.given_at')
			->execute();

		$this->_isManager = $this->_game->canBeManaged($this->sessionWebUser);
	}

	public function executeRoutes(sfRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeObserved($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'просматривать игру'
			)
		);

		$this->_teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')
			->innerJoin('ts.Team')
			->leftJoin('ts.Task')
			->leftJoin('ts.taskStates')
			->select()
			->where('ts.game_id = ?', $this->_game->id)
			->orderBy('ts.Team.name, ts.taskStates.given_at')
			->execute();

		$this->_isManager = $this->_game->canBeManaged($this->sessionWebUser);
	}

	public function executeAnswers(sfRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeObserved($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'просматривать игру'
			)
		);

		$this->_teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')
			->innerJoin('ts.Team')
			->leftJoin('ts.Task')
			->leftJoin('ts.taskStates')
			->select()
			->where('ts.game_id = ?', $this->_game->id)
			->orderBy('ts.Team.name, ts.taskStates.given_at')
			->execute();
	}

	public function executeOverview(sfRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeObserved($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'просматривать игру'
			)
		);

		$this->_teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')
			->innerJoin('ts.Team')
			->leftJoin('ts.taskStates')
			->select()
			->where('ts.game_id = ?', $this->_game->id)
			->orderBy('ts.Team.name, ts.taskStates.given_at')
			->execute();
		
		$this->_tasks = Doctrine::getTable('Task')
			->createQuery('t')
			->leftJoin('t.taskStates')
			->select()
			->where('t.game_id = ?', $this->_game->id)
			->orderBy('t.name')
			->execute();
	}

	public function executePublish(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		try
		{
			$this->_game->short_info_enabled = 1;
			$this->_game->save();
		}
		catch (Exception $e)
		{
			$this->errorRedirect(
				'Анонсировать игру '.$this->_game->name.' не удалось: ошибка базы данных.',
				'gameControl/state?id='.$this->_game->id
			);
		}

		$this->successRedirect(
			'Игра '.$this->_game->name.' анонсирована.',
			'gameControl/state?id='.$this->_game->id
		);
	}

	public function executeVerify(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		if (is_string($res = $this->_game->prepare($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Выполнить предстартовую проверку игры '.$this->_game->name.' не удалось: '.$res,
				'gameControl/state?id='.$this->_game->id
			);
		}

		if (is_array($res))
		{
			$this->report = $res;
			$this->_game->save();
		}
		else
		{
			$this->_game->save();
			$this->successRedirect(
				'Игра '.$this->_game->name.' прошла предстартовую проверку без ошибок и замечаний.',
				'gameControl/state?id='.$this->_game->id
			);
		}
	}

	public function executeReset(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		if (is_string($res = $this->_game->reset($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Перезапустить игру '.$this->_game->name.' не удалось: '.$res,
				'gameControl/state?id='.$this->_game->id
			);
		}

		$this->_game->save();
		$this->successRedirect(
			'Игра '.$this->_game->name.' успешно перезапущена.',
			'gameControl/state?id='.$this->_game->id
		);
	}

	public function executeStart(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		if (is_string($res = $this->_game->start($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Запустить игру'.$this->_game->name.' не удалось: '.$res,
				'gameControl/state?id='.$this->_game->id
			);
		}

		$this->_game->Save();
		$this->successRedirect(
			'Игра '.$this->_game->name.' успешно запущена.',
			'gameControl/state?id='.$this->_game->id
		);
	}

	public function executeStop(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		if (is_string($res = $this->_game->stop($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Остановить игру'.$this->_game->name.' не удалось: '.$res,
				'gameControl/state?id='.$this->_game->id
			);
		}

		$this->_game->save();
		$this->successRedirect(
			'Игра '.$this->_game->name.' успешно остановлена.',
			'gameControl/state?id='.$this->_game->id
		);
	}

	public function executeClose(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		if (is_string($res = $this->_game->close($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Сдать игру '.$this->_game->name.' в архив не удалось: '.$res,
				'gameControl/state?id='.$this->_game->id
			);
		}

		$this->_game->save();
		$this->successRedirect(
			'Игра '.$this->_game->name.' успешно сдана в архив.',
			'gameControl/state?id='.$this->_game->id
		);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		if (is_string($res = $this->_game->updateState($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Пересчитать состояние игры '.$this->_game->name.' не удалось: '.$res,
				'gameControl/state?id='.$this->_game->id
			);
		}

		$this->successRedirect(
			'Состояние игры '.$this->_game->name.' успешно пересчитано в '.Timing::timeToStr(time()).'.',
			'gameControl/state?id='.$this->_game->id
		);
	}

	public function executeAutoUpdate(sfWebRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'обновлять состояние игры',
				'gameControl/state?id='.$this->_game->id
			)
		);
	}

	public function executePoll(sfWebRequest $request)
	{
		$this->forward404Unless(
			$this->_game = Game::byId($request->getParameter('id')),
			'Игра не найдена.'
		);

		$this->errorRedirectUnless(
			$this->_game->canBeManaged($this->sessionWebUser),
			Utils::cannotMessage(
				$this->sessionWebUser->login,
				'обновлять состояние игры',
				'gameControl/state?id='.$this->_game->id
			)
		);

		if (is_bool($res = $this->_game->updateState($this->sessionWebUser)))
		{
			$this->_result = 'Ok';
		}
		else
		{
			$this->_result = var_dump($res); //TODO: Переделать во что-то более дружественное.
		}
	}

	public function executeSetNext(sfWebRequest $request)
	{
		$this->forward404Unless($this->_teamState = TeamState::byId($request->getParameter('teamState')), 'Состояние команды не найдено.');
		$taskId = $request->getParameter('taskId', -1);

		if ($taskId > -1)
		{
			// Диалог выполнен, задание выбрано
			if ($taskId == 0)
			{
				if (is_string($res = $this->_teamState->setNextTask(null, $this->sessionWebUser)))
				{
					$this->errorRedirect(
						'Отменить команде '.$this->_teamState->Team->name.' следующее задание не удалось: '.$res,
						'gameControl/routes?id='.$this->_teamState->Game->id
					);
				}

				$this->_teamState->save();
				$this->successRedirect(
					'Команде '.$this->_teamState->Team->name.' отменено следующее задание.',
					'gameControl/routes?id='.$this->_teamState->Game->id
				);
			}
			else
			{
				$this->forward404Unless($task = Task::byId($taskId), 'Задание не найдено.');
				if (is_string($res = $this->_teamState->setNextTask($task, $this->sessionWebUser)))
				{
					$this->errorRedirect(
						'Назначить команде '.$this->_teamState->Team->name.' следующее задание не удалось: '.$res,
						'gameControl/routes?id='.$this->_teamState->Game->id
					);
				}
				$this->_teamState->save();
				$this->successRedirect(
					'Команде '.$this->_teamState->Team->name.' успешно назначено следующее задание.',
					'gameControl/routes?id='.$this->_teamState->Game->id
				);
			}
		}
		else
		{
			// Диалог только что открыт, надо сформировать списки для выбора.
			$tasksAll = Doctrine::getTable('Task')
				->createQuery('t')
				->select()
				->where('t.game_id = ?', $this->_teamState->game_id)
				->orderBy('t.name')
				->execute();

			$tasksNonBlocked = Doctrine::getTable('Task')
				->createQuery('t')
				->select()
				->where('t.game_id = ?', $this->_teamState->game_id)
				->andWhere('t.locked = ?', false)
				->orderBy('t.name')
				->execute();

			$tasksAvailableAll = $this->_teamState->getTasksAvailableAll();
			$tasksKnown = $this->_teamState->getKnownTasks();
			$tasksAvailableManual = $this->_teamState->getTasksAvailableForManualSelect();

			$this->_tasksInSequenceManual = Task::filterTasks($tasksNonBlocked, $tasksAvailableManual);
			$this->_tasksInSequence = Task::filterTasks($tasksNonBlocked, $tasksAvailableAll);
			$this->_tasksNonSequence = Task::excludeTasks(Task::excludeTasks($tasksNonBlocked, $tasksKnown), $tasksAvailableAll);
			$this->_tasksLocked = Task::excludeTasks(Task::excludeTasks($tasksAll, $tasksNonBlocked), $tasksKnown);

			if (($this->_tasksInSequenceManual->count() <= 0)
				&& ($this->_tasksInSequence->count() <= 0)
				&& ($this->_tasksNonSequence->count() <= 0)
				&& ($this->_tasksLocked->count() <= 0) )
			{
				$this->errorRedirect(
					'У команды '.$this->_teamState->Team->name.' нет доступных для выдачи заданий.',
					'gameControl/state?id='.$this->_game->id
				);
			}
		}
	}

}
?>
