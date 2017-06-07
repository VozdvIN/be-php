<?php

class homeActions extends MyActions
{

	public function executeIndex(sfWebRequest $request)
	{
		$this->_userAuthenticated = $this->session->isAuthenticated();
		$this->_currentRegion = Region::byIdSafe($this->session->getAttribute('region_id'));
	}

}
