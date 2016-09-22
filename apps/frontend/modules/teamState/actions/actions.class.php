<?php
class teamStateActions extends myActions
{

	public function preExecute()
	{
		parent::preExecute();
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->forward404Unless($teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->errorRedirectUnless($teamState->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'изменять настройки команды'));
		$this->form = new teamStateForm($teamState);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->form = new teamStateForm($teamState);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$object = $form->updateObject();
			$this->errorRedirectUnless($object->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'изменять настройки команды'));
			$object->save();
			$this->successRedirect('Настройки команды '.$object->Team->name.' успешно сохранены.', 'gameEdit/teams?id='.$object->game_id);
		}
		else
		{
			$this->errorMessage('Сохранить настройки команды не удалось. Исправьте ошибки и попробуйте снова.');
		}
	}

	public function executeAbandonTask(sfWebRequest $request)
	{
		$this->forward404Unless($teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->errorRedirectUnless($teamState->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'управлять состоянием команды'));
		if (is_string($res = $teamState->abandonTask($this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось отменить текущее задание команды '.$teamState->Team->name.' : '.$res);
		}
		$teamState->save();
		$this->successRedirect('Текущее задание команды '.$teamState->Team->name.' успешно отменено.');
	}
  
	public function executeForceFinish(sfWebRequest $request)
	{
		$this->forward404Unless($teamState = TeamState::byId($request->getParameter('id')), 'Состояние команды не найдено.');
		$this->errorRedirectUnless($teamState->canBeManaged($this->sessionWebUser), Utils::cannotMessage($this->sessionWebUser->login, 'управлять состоянием команды'));
		if (is_string($res = $teamState->finish($this->sessionWebUser)))
		{
			$this->errorRedirect('Не удался принудительный финиш команды '.$teamState->Team->name.' : '.$res);
		}
		$teamState->save();
		$this->successRedirect('Команда '.$teamState->Team->name.' принудительно финишировала.');
	}
}
