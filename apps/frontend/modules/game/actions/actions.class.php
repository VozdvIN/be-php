<?php
class gameActions extends MyActions
{
	public function preExecute()
	{
		parent::preExecute();
	}

	public function executeIndex(sfWebRequest $request)
	{
		$this->checkIndexAccess();
		$this->_games = Game::queryByRegion(Region::byIdSafe($this->session->getAttribute('region_id')))->execute();
	}

	public function executeIndexActive(sfWebRequest $request)
	{
		$this->checkIndexAccess();
		$this->_games = Game::getGamesActive(Region::byIdSafe($this->session->getAttribute('region_id')));
	}

	public function executeIndexAnnounced(sfWebRequest $request)
	{
		$this->checkIndexAccess();
		$this->_games = Game::getGamesForAnnounce(Region::byIdSafe($this->session->getAttribute('region_id')));
	}

	public function executeIndexArchived(sfWebRequest $request)
	{
		$this->checkIndexAccess();
		$this->_games = Game::getGamesArchived(Region::byIdSafe($this->session->getAttribute('region_id')));
	}

	public function executeShow(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->_canManage = $this->_game->isManager($this->sessionWebUser)
				|| $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}

	public function executeShowTeams(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');

		$this->teamList = $this->_game->getTeamsAvailableToPostJoinBy($this->sessionWebUser);
		$this->_canPostJoin = $this->teamList->count() > 0;

		$this->_canManage = $this->_game->isManager($this->sessionWebUser)
				|| $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);

		$this->_teamStates = $this->_game->teamStates;
		$this->_gameCandidates = $this->_game->gameCandidates;
	}

	public function executeShowResults(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');

		$this->_canManage = $this->_game->isManager($this->sessionWebUser)
				|| $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);

		$this->_results = $this->_game->getResults();
	}

	public function executeShowResultsDetails(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');

		$this->_canManage = $this->_game->isManager($this->sessionWebUser)
				|| $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);

		$this->_teamStates = $this->_game->teamStates;
	}

	public function executePostJoinManual(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->_teamList = $this->_game->getTeamsAvailableToPostJoinBy($this->sessionWebUser);
		$this->errorRedirectIf(
			$this->_teamList->count() == 0,
			'Нет команд, от лица которых Вы можете подать заявку на игру.',
			'game/show?id='.$this->_game->id
		);
	}

	public function executePostJoin(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->forward404Unless($this->team = Team::byId($request->getParameter('teamId')), 'Команда не найдена.');

		if (is_string($res = $this->game->postJoin($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Не удалось подать заявку команды '.$this->team->name.' на игру '.$this->game->name.': '.$res,
				'game/showTeams?id='.$this->game->id
			);
		}
		else
		{
			if ($this->game->team_id > 0)
			{
				Utils::sendNotifyGroup(
					'Заявка '.$this->team->name.' на игру '.$this->game->name,
					'Команда "'.$this->team->name.'" подала заявку на вашу игру "'.$this->game->name.'".'."\n"
					.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/teams?id='.$this->game->id,
					$this->game->Team->getLeadersRaw()
				);
			}
			else
			{
				Utils::sendNotifyAdmin(
					'Заявка '.$this->team->name.' на игру '.$this->game->name,
					'Команда "'.$this->team->name.'" подала заявку на игру "'.$this->game->name.'", которой не назначена команда-организатор.'."\n"
					.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/teams?id='.$this->game->id
				);
			}

			$this->successRedirect(
				'Заявка команды '.$this->team->name.' на игру '.$this->game->name.' принята.',
				'game/showTeams?id='.$this->game->id
			);
		}
	}

	private function checkIndexAccess()
	{
		$this->errorRedirectIf(
			$this->sessionWebUser->cannot(Permission::GAME_INDEX, 0),
			Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список игр'),
			'home/index'
		);
	}
}