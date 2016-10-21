<?php

/**
 * taskState actions.
 */
class taskStateActions extends MyActions
{

	public function preExecute()
	{
		parent::preExecute();
	}

	public function executePostAnswers(sfWebRequest $request)
	{
		//TODO: Возврат на страницу задания, вкладка "ответы"
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($taskState = TaskState::byId($request->getParameter('id')), 'Состояние задания не найдено.');
		$redirectUrl = 'play/answers?id='.$taskState->team_state_id;
		$this->errorRedirectUnless($taskState->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'отправлять ответы команды'), $redirectUrl);
		$this->errorRedirectIf($taskState->status != TaskState::TASK_ACCEPTED, 'Для этого задания сейчас нельзя отправлять ответы.', $redirectUrl);

		$form = new SimpleAnswerForm();
		$form->bind($request->getParameter('simpleAnswer'));
		if ( ! $form->isValid())
		{
			$this->errorRedirect(
				'Нельзя подделывать ответы!',
				$redirectUrl
			);
		}

		$formData = $form->getValues();
		$answer = $formData['value'];
		if (trim($answer) == '')
		{
			// Строка с ответами пуста, просто перейдем обратно.
			$this->redirect('play/answers?id='.$this->taskState->TeamState->id);
		}

		if (is_string($res = $taskState->postAnswers($answer, $this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Не удалось отправить ответ(ы):'.$res.'.',
				$redirectUrl
			);
		}

		if ($this->taskState->TeamState->Game->teams_can_update)
		{
			if (is_string($res = $this->taskState->updateState($this->sessionWebUser)))
			{
				$this->errorMessage('Не удалось обновить состояние задания: '.$res);
			}

			$this->taskState->save();
		}

		$this->redirect($redirectUrl);
	}

	public function executeStart(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->start($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Не удалось разрешить старт задания '.$this->taskName.' команды '.$this->teamName.' : '.$res,
				'gameControl/tasks?id='.$this->game->id
			);
		}
		$this->taskState->save();
		$this->successRedirect(
			'Старт заданию '.$this->taskName.' команды '.$this->teamName.' успешно разрешен.',
			'gameControl/tasks?id='.$this->game->id
		);
	}

	public function executeRestart(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->restart($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Не удалось перезапустить задание '.$this->taskState->Task->name.' команды '.$this->teamName.' : '.$res,
				'gameControl/tasks?id='.$this->game->id
			);
		}
		$this->taskState->save();
		$this->successRedirect(
			'Задание '.$this->taskState->Task->name.' команды '.$this->teamName.' успешно перезапущено.',
			'gameControl/tasks?id='.$this->game->id
		);
	}

	public function executeForceAccept(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->accept($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Не удалось подтвердить просмотр задания '.$this->taskName.' командой '.$this->teamName.' : '.$res,
				'gameControl/tasks?id='.$this->game->id
			);
		}
		$this->taskState->save();
		$this->successRedirect(
			'Просмотр задания '.$this->taskName.' командой '.$this->teamName.' успешно подтвержден.',
			'gameControl/tasks?id='.$this->game->id
		);
	}

	/**
	 * @deprecated
	 */
	public function executeSkip(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->doneSkip($this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Команде '.$this->teamName.' не удалось пропустить задание '.$this->taskName.': '.$res,
				'gameControl/tasks?id='.$this->game->id
			);
		}
		$this->taskState->save();
		$this->successRedirect(
			'Задание '.$this->taskName.' команды '.$this->teamName.' успешно пропущено.',
			'gameControl/tasks?id='.$this->game->id
		);
	}

	public function decodeArgs(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless($this->taskState = TaskState::byId($request->getParameter('id')), 'Состояние задания не найдено.');
		$this->game = $this->taskState->TeamState->Game;
		$this->taskName = $this->taskState->Task->name;
		$this->teamName = $this->taskState->TeamState->Team->name;
	}

}
