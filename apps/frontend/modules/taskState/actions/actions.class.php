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
		$this->errorRedirectUnless($taskState->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'отправлять ответы команды'));
		$this->errorRedirectIf($taskState->status != TaskState::TASK_ACCEPTED, 'Для этого задания сейчас нельзя отправлять ответы.');

		$form = new SimpleAnswerForm();
		$form->bind($request->getParameter('simpleAnswer'));
		if ($form->isValid())
		{
			$formData = $form->getValues();
			$answer = $formData['value'];
			if (trim($answer) != '')
			{
				if (is_string($res = $taskState->postAnswers($answer, $this->sessionWebUser)))
				{
					$this->errorRedirect('Не удалось отправить ответ(ы):'.$res.'.');
				}
				else
				{
					if ($this->taskState->TeamState->Game->teams_can_update)
					{
						if (is_string($res = $this->taskState->updateState($this->sessionWebUser)))
						{
							$this->errorMessage('Не удалось обновить состояние задания: '.$res);
						}
						else
						{
							$this->taskState->save();
						}
					}
					$this->successRedirect();
				}
			}
			else
			{
				// Строка с ответами пуста, просто перейдем обратно.
				$this->successRedirect();
			}
		}
		else
		{
			$this->errorRedirect('Нельзя подделывать ответы!');
		}
	}

	public function executeStart(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->start($this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось разрешить старт задания '.$this->taskName.' команды '.$this->teamName.' : '.$res);
		}
		$this->taskState->save();
		$this->successRedirect('Старт заданию '.$this->taskName.' команды '.$this->teamName.' успешно разрешен.');
	}

	public function executeRestart(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->restart($this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось перезапустить задание '.$this->taskName.' команды '.$this->teamName.' : '.$res);
		}
		$this->taskState->save();
		$this->successRedirect('Задание '.$this->taskName.' команды '.$this->teamName.' успешно перезапущено.');
	}

	public function executeForceAccept(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->accept($this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось подтвердить просмотор задания '.$this->taskName.' командой '.$this->teamName.' : '.$res);
		}
		$this->taskState->save();
		$this->successRedirect('Просмотр задания '.$this->taskName.' командой '.$this->teamName.' успешно подтвержден.');
	}

	public function executeSkip(sfWebRequest $request)
	{
		$this->decodeArgs($request);
		if (is_string($res = $this->taskState->doneSkip($this->sessionWebUser)))
		{
			$this->errorRedirect('Команде '.$this->teamName.' не удалось пропустить задание '.$this->taskName.': '.$res);
		}
		$this->taskState->save();
		$this->successRedirect('Задание '.$this->taskName.' команды '.$this->teamName.' успешно пропущено.');
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
