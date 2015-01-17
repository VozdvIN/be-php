<?php

/**
 * SystemSettings form.
 *
 * @package    sf
 * @subpackage form
 * @author     VozdvIN
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class SystemSettingsForm extends BaseSystemSettingsForm
{
  public function configure()
  {
    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'fast_user_register' => new sfValidatorBoolean(array('required' => false)),
      'email_team_create'  => new sfValidatorBoolean(array('required' => false)),
      'fast_team_create'   => new sfValidatorBoolean(array('required' => false)),
      'email_game_create'  => new sfValidatorBoolean(array('required' => false)),
    ));
    $this->getWidgetSchema()->setLabels(array(
      'email_team_create'  => 'Cоздание команд по почте:',
      'email_game_create'  => 'Cоздание игр по почте:',
      'fast_team_create'   => 'Быстрое создание команд:',
      'fast_user_register' => 'Быстрая регистрация:',
    ));
    $this->getWidgetSchema()->setHelps(array(
      'email_team_create'  => 'переходом по ссылке из письма.',
      'email_game_create'  => 'переходом по ссылке из письма.',
      'fast_team_create'   => 'самостоятельным утверждением заявки без подтверждения по почте.|Использовать c осторожноcтью!',
      'fast_user_register' => 'пользователей без подтверждения по почте.|Использовать c большой осторожноcтью во избежание авторегистраций!',
    ));
  }
}
