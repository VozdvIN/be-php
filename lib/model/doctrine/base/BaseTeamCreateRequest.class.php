<?php

/**
 * BaseTeamCreateRequest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $web_user_id
 * @property string $name
 * @property string $full_name
 * @property string $description
 * @property string $tag
 * @property WebUser $WebUser
 * 
 * @method integer           getId()          Returns the current record's "id" value
 * @method integer           getWebUserId()   Returns the current record's "web_user_id" value
 * @method string            getName()        Returns the current record's "name" value
 * @method string            getFullName()    Returns the current record's "full_name" value
 * @method string            getDescription() Returns the current record's "description" value
 * @method string            getTag()         Returns the current record's "tag" value
 * @method WebUser           getWebUser()     Returns the current record's "WebUser" value
 * @method TeamCreateRequest setId()          Sets the current record's "id" value
 * @method TeamCreateRequest setWebUserId()   Sets the current record's "web_user_id" value
 * @method TeamCreateRequest setName()        Sets the current record's "name" value
 * @method TeamCreateRequest setFullName()    Sets the current record's "full_name" value
 * @method TeamCreateRequest setDescription() Sets the current record's "description" value
 * @method TeamCreateRequest setTag()         Sets the current record's "tag" value
 * @method TeamCreateRequest setWebUser()     Sets the current record's "WebUser" value
 * 
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTeamCreateRequest extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('team_create_requests');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('web_user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('name', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 32,
             ));
        $this->hasColumn('full_name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('tag', 'string', 32, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 32,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('WebUser', array(
             'local' => 'web_user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}