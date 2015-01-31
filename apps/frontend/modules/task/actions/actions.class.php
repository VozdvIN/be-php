<?php
class taskActions extends MyActions
{

	public function executeParams(sfWebRequest $request)
	{
		$this->pageInit($request);
	}

	public function executeTips(sfWebRequest $request)
	{
		$this->pageInit($request);
		$this->_tips = Doctrine::getTable('Tip')
			->createQuery('t')->innerJoin('t.Task')
			->select()->where('t.task_id = ?', $this->_task->id)->orderBy('t.delay')
			->execute();
	}

	public function executeAnswers(sfWebRequest $request)
	{
		$this->pageInit($request);
		$this->_answers = Doctrine::getTable('Answer')
			->createQuery('a')->innerJoin('a.Task')
			->select()->where('a.task_id = ?', $this->_task->id)->orderBy('a.value')
			->execute();
	}
	
	public function executeConstraints(sfWebRequest $request)
	{
		$this->pageInit($request);
		$this->_taskConstraints = $this->_task->taskConstraints;		
	}

	public function executeTransitions(sfWebRequest $request)
	{
		$this->pageInit($request);
		$this->_taskTransitions = $this->_task->taskTransitions;		
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->forward404Unless($game = Game::byId($request->getParameter('gameId')), 'Игра не найдена');
		$this->errorRedirectUnless($game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'создавать задания для игры'));
		$newTask = new Task;
		$newTask->game_id = $game->id;
		$newTask->name = 'Задание'.($game->tasks->count()+1);
		$newTask->public_name = 'Задание'.($game->tasks->count()+1);
		$this->form = new taskForm($newTask);
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new taskForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($task = Task::byId($request->getParameter('id')), 'Задание не найдено.');
		$this->errorRedirectUnless($task->Game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'изменять задания для игры'));
		$this->form = new taskForm($task);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($task = Task::byId($request->getParameter('id')), 'Задание не найдено.');
		$this->form = new taskForm($task);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::DELETE));
		$request->checkCSRFProtection();
		$this->forward404Unless($this->task = Task::byId($request->getParameter('id')), 'Задание не найдено.');
		$this->errorRedirectUnless($this->task->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'удалять задания для игры'));
		$game_id = $this->task->game_id;
		$this->task->delete();
		$this->successRedirect('Задание успешно удалено.', 'game/tasks?id='.$game_id);
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$object = $form->updateObject();
			$wasNew = $object->isNew();
			$this->errorRedirectUnless($object->Game->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'изменять задания для игры'));
			$object->initDefaults();
			$object->save();
			if ($wasNew)
			{
				// Задание новое, надо редактировать его формулировку.
				$tip = $object->tips->getFirst();
				$this->successRedirect('Задание '.$object->name.' игры '.$object->Game->name.' успешно сохранено. Отредактируйте его формулировку.', 'tip/edit?id='.$tip->id);
			}
			else
			{
				// Задание не новое, редактировать его формулировку не надо.
				$this->successRedirect('Задание '.$object->name.' игры '.$object->Game->name.' успешно сохранено.', 'task/params?id='.$object->id);
			}
		}
		else
		{
			$this->errorMessage('Сохранить ответ не удалось. Исправьте ошибки и попробуйте снова.');
		}
	}

	public function executeTransitionsBatch(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$request->checkCSRFProtection();
		$this->forward404Unless($this->_task = Task::byId($request->getParameter('id')), 'Задание не найдено');
		$this->errorRedirectUnless($this->_task->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать задания игры'));
		$operation = $request->getParameter('operation');
		if ($operation === 'allManual')
		{
			try
			{
				$this->_task->allTransitionsSetManual(true, $this->sessionWebUser);
			}
			catch (Exception $e)
			{
				$this->errorRedirect('Не удалось назначить признак "Разрешить выбор вручную": '.$e->getMessage());
			}
			$this->successRedirect('Всем фильтрам назначен признак "Разрешить выбор вручную"');
		}
		elseif ($operation === 'allAuto')
		{
			try
			{
				$this->_task->allTransitionsSetManual(false, $this->sessionWebUser);
			}
			catch (Exception $e)
			{
				$this->errorRedirect('Не удалось назначить признак "Разрешить выбор вручную": '.$e->message);
			}
			$this->successRedirect('Со всех фильтров снят признак "Разрешить выбор вручную"');
		}
		elseif ($operation === 'addAll')
		{
			try
			{
				$this->_task->addTransitionsToAllTasks($this->sessionWebUser);
			}
			catch (Exception $e)
			{
				$this->errorRedirect('Не удалось добавить фильтры: '.$e->getMessage());
			}
			$this->successRedirect('Добавлены фильтры перехода на все остальные задания');
		}
		else
		{
		  $this->errorRedirect('Неизвестная операция над фильтрами: '.$operation);
		}
	}
  
	protected function pageInit(sfWebRequest $request)
	{
		$this->forward404Unless($this->_task = Task::byId($request->getParameter('id')), 'Задание не найдено');
		$this->errorRedirectUnless($this->_task->canBeObserved($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать задание'));
		$this->_isManager = $this->_task->canBeManaged($this->sessionWebUser);
		$this->_isModerator = Task::isModerator($this->sessionWebUser);		
	}
}
