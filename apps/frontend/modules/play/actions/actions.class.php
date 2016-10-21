<?php

/**
 * Team current task actions.
 */

class playActions extends MyActions
{
	
	public function preExecute()
	{
		parent::preExecute();
	}
	
	public function executeTask(sfWebRequest $request)
	{
		$this->forward404Unless($this->teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->errorRedirectUnless($this->teamState->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать текущее задание команды'));
		$this->updateIfTeamCan($this->teamState);
		
		switch ($this->teamState->status)
		{
			case TeamState::TEAM_WAIT_GAME: $this->setTemplate('taskTeamWaitGame'); break;
			case TeamState::TEAM_WAIT_START: $this->setTemplate('taskTeamWaitStart'); break;
			case TeamState::TEAM_WAIT_TASK:
				$this->availableTasksManual = $this->teamState->getTasksAvailableForManualSelect();
				if (($this->availableTasksManual->count() > 0) && ($this->teamState->task_id <= 0))
				{
					$this->isLeader = $this->teamState->Team->canBeManaged($this->sessionWebUser);
					$this->setTemplate('taskTeamSelectTask');
				}
				else
				{
					$this->setTemplate('taskTeamWaitTask');
				}
				break;
			case TeamState::TEAM_HAS_TASK: 
				$taskState = $this->teamState->getCurrentTaskState();
				if ( ! $taskState)
				{
					$this->setTemplate('taskCurrentNotFound');
				}
				else
				{
					$this->taskState = $taskState;
					$this->confirmTaskDisplayIfRequired($taskState);
					
					switch ($taskState->status) {
						case TaskState::TASK_GIVEN:
							$this->setTemplate('taskGiven');
							break;

						case TaskState::TASK_STARTED:
							// Игроки не должны видеть задание в таком состоянии.
							// Из этого состояния задание должно быть выведено перед первым просмотром.
							$this->setTemplate('taskStarted');
							break;

						case TaskState::TASK_ACCEPTED:
						case TaskState::TASK_CHEAT_FOUND:
							$this->isLeader =
								$taskState->TeamState->Team->isLeader($this->sessionWebUser)
								|| $taskState->TeamState->Game->canBeManaged($this->sessionWebUser);
							$this->setTemplate('taskActive');
							break;

						case TaskState::TASK_DONE:
						case TaskState::TASK_DONE_SUCCESS:
						case TaskState::TASK_DONE_TIME_FAIL:
						case TaskState::TASK_DONE_SKIPPED:
						case TaskState::TASK_DONE_GAME_OVER:
						case TaskState::TASK_DONE_BANNED:
						case TaskState::TASK_DONE_ABANDONED:
							$this->setTemplate('taskDone');
							break;

						default:
							throw new Exception('NowActions::executeTask: Неизвестное состояние задания - #'.$_taskState->status);
					}
				}
				break;
			case TeamState::TEAM_FINISHED:
				$this->setTemplate('taskTeamFinished');
				break;

			default:
				throw new Exception('NowActions::executeTask: Неизвестное состояние команды - #'.$this->teamState->status);
		}
	}
	
	public function executeAnswers(sfWebRequest $request)
	{
		$this->forward404Unless($this->teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->errorRedirectUnless($this->teamState->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать текущее задание команды'));
		$this->updateIfTeamCan($this->teamState);
		
		if ($this->teamState->status == TeamState::TEAM_HAS_TASK)
		{
			$this->taskState = $this->teamState->getCurrentTaskState();
			if ($this->taskState)
			{
				$this->confirmTaskDisplayIfRequired($this->taskState);
				$this->restAnswers = $this->taskState->getRestAnswers();
				$this->goodAnswers = $this->taskState->getGoodPostedAnswers();
				$this->beingVerifiedAnswers = $this->taskState->getBeingVerifiedPostedAnswers();
				$this->badAnswers = $this->taskState->getBadPostedAnswers();
				$this->badAnswersLeft = $this->taskState->Task->try_count_local - $this->badAnswers->count();
				$this->setTemplate('answers');
			}
			else
			{
				$this->setTemplate('answersNoTask');
			}
		}
		else
		{
			$this->setTemplate('answersNoTask');
		}
	}
	
	public function executeStats(sfWebRequest $request)
	{
		$this->forward404Unless($this->teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->errorRedirectUnless($this->teamState->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать текущее задание команды'));
		$this->updateIfTeamCan($this->teamState);
		
		$this->_taskStates = Doctrine::getTable('TaskState')
			->createQuery('ts')
			->innerJoin('ts.Task')
			->select()
			->where('ts.team_state_id = ?', $this->teamState->id)
			->andWhere('ts.status >= ?', TaskState::TASK_ACCEPTED)
			->execute();
	}
	
	public function executeStatsRecall(sfWebRequest $request)
	{
		$this->forward404Unless($this->taskState = TaskState::byId($request->getParameter('id')), 'Состояние задания не найдено.');
		$this->errorRedirectUnless($this->taskState->TeamState->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать текущее задание команды'));
		$this->errorRedirectUnless($this->taskState->status >= TaskState::TASK_ACCEPTED, Utils::cannotMessage($this->sessionWebUser->login, 'просматривать еще не прочитанное задание'));
		$this->updateIfTeamCan($this->taskState->TeamState);
		$this->confirmTaskDisplayIfRequired($this->taskState);

		$this->restAnswers = $this->taskState->getRestAnswers();
		$this->goodAnswers = $this->taskState->getGoodPostedAnswers();
		$this->beingVerifiedAnswers = $this->taskState->getBeingVerifiedPostedAnswers();
		$this->badAnswers = $this->taskState->getBadPostedAnswers();
	}	
	
	protected function updateIfTeamCan(TeamState $teamState)
	{
		if ($teamState->Game->teams_can_update)
		{
			if (is_string($res = $teamState->updateState($this->sessionWebUser)))
			{
				$this->errorMessage('Не удалось обновить состояние команды: '.$res);
			}
			else
			{
				$teamState->save();
			}
		}
	}
	
	protected function confirmTaskDisplayIfRequired(TaskState $taskState)
	{
		// Если это задание еще не было просмотрено,
		// то надо подтвердить его просмотр,
		// но только если текущий пользователь - игрок.
		if ( ($taskState->status == TaskState::TASK_STARTED)
			 && ($taskState->accepted_at == 0)
			 && ($taskState->TeamState->Team->isPlayer($this->sessionWebUser)) ) // TODO: Создает минимум 3 запроса к БД, оптимизировать?
		{
			if (is_string($res = $taskState->accept($this->sessionWebUser)))
			{
				$this->errorRedirect('Обратитесь к организаторам - не удалось подтвердить просмотр Вами задания: '.$res);
			}
			else
			{
				$taskState->save();
			}
		}
	}
	
}