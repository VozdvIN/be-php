<?php

/**
 * SystemSettings form base class.
 *
 * @method SystemSettings getObject() Returns the current form's model object
 *
 * @package    sf
 * @subpackage form
 * @author     VozdvIN
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSystemSettingsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'fast_user_register'      => new sfWidgetFormInputCheckbox(),
      'fast_team_create'        => new sfWidgetFormInputCheckbox(),
      'email_team_create'       => new sfWidgetFormInputCheckbox(),
      'email_game_create'       => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fast_user_register'      => new sfValidatorBoolean(array('required' => false)),
      'fast_team_create'        => new sfValidatorBoolean(array('required' => false)),
      'email_team_create'       => new sfValidatorBoolean(array('required' => false)),
      'email_game_create'       => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('system_settings[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SystemSettings';
  }

}
