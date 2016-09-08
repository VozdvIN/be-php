<?php

/**
 * TeamCreateRequest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class TeamCreateRequest extends BaseTeamCreateRequest implements IStored
{
  const MAX_REQUESTS_PER_USER = 3; // Максимальное число активных заявок от одного пользователя.
 
  //// IStored ////
  
  static function all()
  {
    return Utils::all('TeamCreateRequest');
  }
 
  static function byId($id)
  {
    return Utils::byId('TeamCreateRequest', $id);
  }
  
  //// Public ////

	/**
	 * Возвращает список заявок на создание команды, поданные пользователем
	 * 
	 * @param  WebUser  $user 
	 * @return Doctrine_Colleсtion<TeamCreateRequest>
	 */
	public static function getForWithRelations(WebUser $user)
	{
		$query = Doctrine::getTable('TeamCreateRequest')
			->createQuery('tcr')
			->innerJoin('tcr.WebUser')
			->select()
			->where('tcr.web_user_id = ?',  $user->id)
			->execute();

		return $query;
	}

  /**
   * Выполняет создание команды по заявке.
   * 
   * @param TeamCreateRequest $teamCreateRequest 
   * 
   * @return Team Созданная команда
   */
  public static function doCreate(TeamCreateRequest $teamCreateRequest)
  {
    $team = new Team;
    $team->name = $teamCreateRequest->name;
    $team->full_name = $teamCreateRequest->full_name;
    $team->region_id = $teamCreateRequest->WebUser->region_id;
    $team->save(); //Требуется, так как иначе не удастся включить капитана.
    //Так как команда еще не существует, то в нее можно просто включить
    //автора заявки без всяких проверок.
    $teamPlayer = new TeamPlayer;
    $teamPlayer->team_id = $team->id;
    $teamPlayer->web_user_id = $teamCreateRequest->web_user_id;
    $teamPlayer->is_leader = true;
    $team->teamPlayers->add($teamPlayer);
    $team->save();
    $teamCreateRequest->delete();
    return $team;
  }
  
}