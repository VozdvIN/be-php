<?php

/**
 * BaseSystemSettings
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $site_name
 * @property string $site_domain
 * @property integer $games_announce_interval
 * @property boolean $fast_user_register
 * @property boolean $fast_team_create
 * @property boolean $email_team_create
 * @property boolean $email_game_create
 * @property string $notify_email_addr
 * @property string $contact_email_addr
 * @property string $smtp_host
 * @property integer $smtp_port
 * @property string $smtp_security
 * @property string $smtp_login
 * @property string $smtp_password
 * 
 * @method integer        getId()                      Returns the current record's "id" value
 * @method string         getSiteName()                Returns the current record's "site_name" value
 * @method string         getSiteDomain()              Returns the current record's "site_domain" value
 * @method integer        getGamesAnnounceInterval()   Returns the current record's "games_announce_interval" value
 * @method boolean        getFastUserRegister()        Returns the current record's "fast_user_register" value
 * @method boolean        getFastTeamCreate()          Returns the current record's "fast_team_create" value
 * @method boolean        getEmailTeamCreate()         Returns the current record's "email_team_create" value
 * @method boolean        getEmailGameCreate()         Returns the current record's "email_game_create" value
 * @method string         getNotifyEmailAddr()         Returns the current record's "notify_email_addr" value
 * @method string         getContactEmailAddr()        Returns the current record's "contact_email_addr" value
 * @method string         getSmtpHost()                Returns the current record's "smtp_host" value
 * @method integer        getSmtpPort()                Returns the current record's "smtp_port" value
 * @method string         getSmtpSecurity()            Returns the current record's "smtp_security" value
 * @method string         getSmtpLogin()               Returns the current record's "smtp_login" value
 * @method string         getSmtpPassword()            Returns the current record's "smtp_password" value
 * @method SystemSettings setId()                      Sets the current record's "id" value
 * @method SystemSettings setSiteName()                Sets the current record's "site_name" value
 * @method SystemSettings setSiteDomain()              Sets the current record's "site_domain" value
 * @method SystemSettings setGamesAnnounceInterval()   Sets the current record's "games_announce_interval" value
 * @method SystemSettings setFastUserRegister()        Sets the current record's "fast_user_register" value
 * @method SystemSettings setFastTeamCreate()          Sets the current record's "fast_team_create" value
 * @method SystemSettings setEmailTeamCreate()         Sets the current record's "email_team_create" value
 * @method SystemSettings setEmailGameCreate()         Sets the current record's "email_game_create" value
 * @method SystemSettings setNotifyEmailAddr()         Sets the current record's "notify_email_addr" value
 * @method SystemSettings setContactEmailAddr()        Sets the current record's "contact_email_addr" value
 * @method SystemSettings setSmtpHost()                Sets the current record's "smtp_host" value
 * @method SystemSettings setSmtpPort()                Sets the current record's "smtp_port" value
 * @method SystemSettings setSmtpSecurity()            Sets the current record's "smtp_security" value
 * @method SystemSettings setSmtpLogin()               Sets the current record's "smtp_login" value
 * @method SystemSettings setSmtpPassword()            Sets the current record's "smtp_password" value
 * 
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSystemSettings extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('system_settings');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('site_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'Beaver\'s Engine v0.15.5b',
             'length' => 255,
             ));
        $this->hasColumn('site_domain', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'localhost',
             'length' => 255,
             ));
        $this->hasColumn('games_announce_interval', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 31,
             ));
        $this->hasColumn('fast_user_register', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('fast_team_create', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('email_team_create', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => true,
             ));
        $this->hasColumn('email_game_create', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => false,
             ));
        $this->hasColumn('notify_email_addr', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'do_not_reply@somehost.inf',
             'length' => 255,
             ));
        $this->hasColumn('contact_email_addr', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'feedback@somehost.inf',
             'length' => 255,
             ));
        $this->hasColumn('smtp_host', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'default' => 'smtp.somehost.inf',
             'length' => 255,
             ));
        $this->hasColumn('smtp_port', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 25,
             ));
        $this->hasColumn('smtp_security', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             ));
        $this->hasColumn('smtp_login', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('smtp_password', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}