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
		$this->_games = Game::queryByRegion(Region::byIdSafe($this->session->getAttribute('region_id')))
				->andWhere('short_info_enabled = ?', true)
				->execute();
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
		$this->prepareGame($request);
	}

	public function executeShowTeams(sfWebRequest $request)
	{
		$this->prepareGame($request);

		if ($this->_game->short_info_enabled == 0)
		{
			$this->warningRedirect('Игра еще не анонсирована', 'game/show?id='.$this->_game->id);
		}

		$this->teamList = $this->_game->getTeamsAvailableToPostJoinBy($this->sessionWebUser);
		$this->_canPostJoin = $this->teamList->count() > 0;

		$this->_teamStates = $this->_game->teamStates;
		$this->_gameCandidates = $this->_game->gameCandidates;
	}

	public function executeShowResults(sfWebRequest $request)
	{
		$this->prepareGame($request);

		if ($this->_game->short_info_enabled == 0)
		{
			$this->warningRedirect('Игра еще не анонсирована', 'game/show?id='.$this->_game->id);
		}

		$this->_results = $this->_game->getResults();
	}

	public function executeShowResultsDetails(sfWebRequest $request)
	{
		$this->prepareGame($request);

		if ($this->_game->short_info_enabled == 0)
		{
			$this->successRedirect('Игра еще не анонсирована', 'game/show?id='.$this->_game->id);
		}

		$this->_teamStates = $this->_game->teamStates;
	}

	public function executePostJoinManual(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->errorRedirectIf(
			$this->_game->short_info_enabled == 0,
			'Игра еще не анонсирована, регистрация закрыта.',
			'game/show?id='.$this->_game->id
		);

		$this->_teamList = $this->_game->getTeamsAvailableToPostJoinBy($this->sessionWebUser);
		$this->errorRedirectIf(
			$this->_teamList->count() == 0,
			'Нет команд, от лица которых Вы можете подать заявку на игру.',
			'game/show?id='.$this->_game->id
		);
	}

	public function executePostJoin(sfWebRequest $request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->forward404Unless($this->team = Team::byId($request->getParameter('teamId')), 'Команда не найдена.');

		if (is_string($res = $this->_game->postJoin($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect(
				'Не удалось подать заявку команды '.$this->team->name.' на игру '.$this->_game->name.': '.$res,
				'game/showTeams?id='.$this->_game->id
			);
		}
		else
		{
			if ($this->_game->team_id > 0)
			{
				Utils::sendNotifyGroup(
					'Заявка '.$this->team->name.' на игру '.$this->_game->name,
					'Команда "'.$this->team->name.'" подала заявку на вашу игру "'.$this->_game->name.'".'."\n"
					.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/teams?id='.$this->_game->id,
					$this->_game->Team->getLeadersRaw()
				);
			}
			else
			{
				Utils::sendNotifyAdmin(
					'Заявка '.$this->team->name.' на игру '.$this->_game->name,
					'Команда "'.$this->team->name.'" подала заявку на игру "'.$this->_game->name.'", которой не назначена команда-организатор.'."\n"
					.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/teams?id='.$this->_game->id
				);
			}

			$this->successRedirect(
				'Заявка команды '.$this->team->name.' на игру '.$this->_game->name.' принята.',
				'game/showTeams?id='.$this->_game->id
			);
		}
	}

	public function executeCancelJoin(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->forward404Unless($this->team = Team::byId($request->getParameter('teamId')), 'Команда не найдена.');
		if (is_string($res = $this->game->cancelJoin($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось отменить заявку команды '.$this->team->name.' на игру '.$this->game->name.': '.$res);
		}
		else
		{
			Utils::sendNotifyGroup(
				'Отклонена регистрация '.$this->team->name.' на игру '.$this->game->name,
				'Заявка вашей команды "'.$this->team->name.'" на участие в игре "'.$this->game->name.'" отклонена.',
				$this->team->getLeadersRaw()
			);

			$this->successRedirect(
				'Отменена заявка команды '.$this->team->name.' на игру '.$this->game->name.'.',
				'game/showTeams?id='.$this->game->id
			);
		}
	}

	public function executeRemoveTeam(sfWebRequest $request)
	{
		$this->forward404Unless($this->game = Game::byId($request->getParameter('id')), 'Игра не найдена.');
		$this->forward404Unless($this->team = Team::byId($request->getParameter('teamId')), 'Команда не найдена.');
		if (is_string($res = $this->game->unregisterTeam($this->team, $this->sessionWebUser)))
		{
			$this->errorRedirect('Не удалось снять команду '.$this->team->name.' с игры '.$this->game->name.': '.$res);
		}
		else
		{
			Utils::sendNotifyGroup(
				'Команда '.$this->team->name.' снята с игры '.$this->game->name,
				'Ваша команда "'.$this->team->name.'" снята с игры "'.$this->game->name.'".',
				$this->team->getLeadersRaw()
			);

			$this->successRedirect(
				'Команда '.$this->team->name.' снята с игры '.$this->game->name.'.',
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

	private function prepareGame($request)
	{
		$this->forward404Unless($this->_game = Game::byId($request->getParameter('id')), 'Игра не найдена.');

		$this->_canManage = $this->_game->isActor($this->sessionWebUser)
								|| $this->sessionWebUser->can(Permission::GAME_MODER, $this->_game->id);
	}
}