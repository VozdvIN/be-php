<?php
class gameControlComponents extends sfComponents
{
	/**
	 * Формирует телеметрию
	 *
	 * @param  string  $gameId  Идентификатор игры, для которой формируется отчет
	 */
	public function executeReport()
	{
		$game = Game::byId($this->gameId);

		$teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')
			->select()
				->innerJoin('ts.Game')
				->innerJoin('ts.Team')
				->leftJoin('ts.taskStates')
			->where('game_id = ?', $game->id)
			->orderBy('ts.taskStates.given_at')
			->execute();
		$teamStatesIds = DCTools::idsToArray($teamStates);

		$taskStates = Doctrine::getTable('TaskState')
			->createQuery('ts')
			->select()
				->innerJoin('ts.TeamState')
				->innerJoin('ts.Task')
				->leftJoin('ts.usedTips')
				->leftJoin('ts.postedAnswers')
			->whereIn('team_state_id', $teamStatesIds)
			->execute();
		$taskStatesIds = DCTools::idsToArray($taskStates);
		
		$usedTips = Doctrine::getTable('UsedTip')
			->createQuery('ut')
			->select()
				->innerJoin('ut.TaskState')
				->innerJoin('ut.Tip')
			->whereIn('task_state_id', $taskStatesIds)
			->execute();
		
		$postedAnswers = Doctrine::getTable('PostedAnswer')
			->createQuery('pa')
			->select()
				->innerJoin('pa.WebUser')
			->whereIn('task_state_id', $taskStatesIds)
			->execute();

		$this->_teamStates = $teamStates;
		$this->_taskStates = $taskStates;
		$this->_usedTips = $usedTips;
		$this->_postedAnswers = $postedAnswers;
	}

	/**
	 * Формирует результаты
	 *
	 * @param  string  $gameId  Идентификатор игры, для которой формируется отчет
	 */
	public function executeResults()
	{
		$game = Game::byId($this->gameId);
		
		$teamStates = Doctrine::getTable('TeamState')
			->createQuery('ts')
			->select()			
			->where('game_id = ?', $game->id)
			->execute();
		
		$teamIds = DCTools::fieldValuesToArray($teamStates, 'team_id', true, true);
		
		$teams = Doctrine::getTable('Team')
			->createQuery('t')
			->select()			
			->whereIn('id', $teamIds)
			->execute();
		
		$this->_results = $game->getGameResults();
		$this->_teams = $teams;
	}
}

