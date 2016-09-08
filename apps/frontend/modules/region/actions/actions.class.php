<?php

class regionActions extends myActions
{

	public function executeIndex(sfWebRequest $request)
	{
		$this->checkRights();
		$this->_regions = Doctrine_Core::getTable('Region')
			->createQuery('r')
			->select()
			->orderBy('r.name')
			->execute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->checkRights();
		$this->form = new RegionForm();
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->checkRights();
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new RegionForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeEdit(sfWebRequest $request)
	{
		$this->checkRights();
		$this->forward404Unless($region = Doctrine_Core::getTable('Region')->find(array($request->getParameter('id'))), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
		$this->form = new RegionForm($region);
	}

	public function executeUpdate(sfWebRequest $request)
	{
		$this->checkRights();
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($region = Doctrine_Core::getTable('Region')->find(array($request->getParameter('id'))), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
		$this->form = new RegionForm($region);
		$this->processForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$this->checkRights();
		$request->checkCSRFProtection();
		$this->forward404Unless($region = Doctrine_Core::getTable('Region')->find(array($request->getParameter('id'))), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
		if ($region->id == Region::DEFAULT_REGION)
		{
			$this->errorRedirect('Нельзя удалять игровой проект, используемый по умолчанию.', 'region/index');
		}
		$region->delete();
		$this->successRedirect('Игровой проект успешно удален.', 'region/index');
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$region = $form->save();
			$this->successRedirect('Игровой проект успешно сохранен.', 'region/index');
		}
	}

	public function executeSetCurrent(sfWebRequest $request)
	{
		if ($request->isMethod(sfRequest::POST))
		{
			$this->forward404Unless($region = Region::byId($request->getParameter('id')), 'Игровой проект не найден.');
			$this->session->setAttribute('region_id', $region->id);
			$this->successRedirect('Установлен текущий игровой проект - '.$region->name);
		}
		else
		{
			$this->_regions = Doctrine_Core::getTable('Region')
				->createQuery('r')
				->orderBy('r.name')
				->select()
				->execute();
			$this->_selfRegionId = ($this->sessionWebUser instanceof WebUser)
				? $this->sessionWebUser->getRegionSafe()->id
				: Region::DEFAULT_REGION;
		}
	}

	protected function checkRights()
	{
		$this->errorRedirectUnless(
			(($this->sessionWebUser instanceof WebUser)
				&& ($this->sessionWebUser->can(Permission::ROOT, 0))),
			Utils::cannotMessage('Неавторизованный пользователь', 'управлять игровыми проектами')
		);
	}
}
