<?php

class regionActions extends myActions
{
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
}
