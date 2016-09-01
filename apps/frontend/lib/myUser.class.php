<?php

class myUser extends sfBasicSecurityUser
{

	/**
	 * Возвращает пользователя активного сеанса, если он залогинился и существует
	 * 
	 * @return  WebUser  
	 */
	public function getSessionWebUser()
	{
		if (!$this->isAuthenticated())
		{
			return false;
		}

		if ($this->hasAttribute('id', 0)) // Будет инициализировано указанным значением, если нет такого атрибута
		{
			return WebUser::byId($this->getAttribute('id'));
		}

		return false;
	}

	public function getSessionRegionId()
	{
		if ( ! $this->hasAttribute('region_id'))
		{
			$this->setAttribute('region_id', Region::DEFAULT_REGION);
		}

		return $this->getAttribute('region_id');
	}
}
