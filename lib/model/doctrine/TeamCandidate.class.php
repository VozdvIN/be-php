<?php

/**
 * TeamCandidate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class TeamCandidate extends BaseTeamCandidate
{
	/**
	 * Возвращает список команд, куда пользователь подал заявки
	 * 
	 * @param  WebUser  $user 
	 * @return Doctrine_Collcetion<TeamCandidate>
	 */
	public static function getForWithRelations(WebUser $user)
	{
		return Doctrine::getTable('TeamCandidate')
			->createQuery('tc')
			->innerJoin('tc.Team')
			->innerJoin('tc.WebUser')
			->select()
			->where('tc.web_user_id = ?', $user->id)
			->execute();
	}
}