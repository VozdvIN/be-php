<?php

class homeActions extends MyActions
{

  public function executeIndex(sfWebRequest $request)
  {
    $this->_userAuthenticated = $this->session->isAuthenticated();
    $this->_currentRegion = Region::byIdSafe($this->session->getAttribute('region_id'));
    $this->_games = Game::getGamesForAnnounce();    
    
    $localNewsName = 'Новости-'.(($this->_currentRegion->id != Region::DEFAULT_REGION) ? $this->_currentRegion->name : '(Общие)');
    
    $this->_localNews = Article::byName($localNewsName);
    
    $this->_canEditNews =
        $this->_userAuthenticated
        && ($this->_localNews !== false)
        && ($this->sessionWebUser->can(Permission::ARTICLE_MODER, $this->_localNews->id));
  }
  
}
