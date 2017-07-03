<?php

/**
 * WebUser
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class WebUser extends BaseWebUser implements IStored, INamed, IAuth, IRegion
{
  const MIN_NAME_LENGTH = 2;
  const MIN_PWD_LENGTH = 5;

  /* Аккаунт админа по умолчанию:
   * БД: admin|f99cf418670b465d4ee37b0bac36265e, Utils::PASSWORD_SALT = 'cHaNgEtHiS'
   * Вход: admin|admin
   * Для создания админа нужно выполнить на пустой БД скрипт:
INSERT INTO web_users(login, pwd_hash, is_enabled) VALUES ('admin', 'f99cf418670b465d4ee37b0bac36265e', 1);
INSERT INTO granted_permissions(web_user_id, permission_id) VALUES ('1', '666');
   */

  //// IStored ////

  static function all()
  {
    return Utils::all('WebUser', 'login');
  }

  static function byId($id)
  {
    return Utils::byId('WebUser', $id);
  }

  //// INamed ////

  function getInnerName()
  {
    return $this->login;
  }

  static function byName($name)
  {
    return Utils::byField('WebUser', 'login', $name);
  }

  //// IAuth ////

  static function isModerator(WebUser $account)
  {
    return $account->can(Permission::WEB_USER_MODER, 0);
  }

  function canBeManaged(WebUser $account)
  {
    if ($account->can(Permission::WEB_USER_MODER, $this->id))
    {
      return true;
    }
    elseif (WebUser::isModerator($account))
    {
      return true;
    }
    elseif ($account->id == $this->id)
    {
      return true;
    }
    return false;
  }

  function canBeObserved(WebUser $account)
  {
    if ($account->can(Permission::WEB_USER_SHOW, $this->id))
    {
      return true;
    }
    elseif ($this->canBeManaged($account))
    {
      return true;
    }
    return false;
  }

  //// IRegion ////

  public static function byRegion($region)
  {
    return Utils::byRegion('WebUser', $region, 'login');
  }
  
  public function getRegionSafe()
  {
    return Region::byIdSafe($this->region_id);
  }
  
  //// Public ////

	public static function allSorted()
	{
		return Doctrine_Core::getTable('WebUser')
			->createQuery('wu')
			->select()
			->orderBy('wu.login')
			->execute();
	}

	public static function allBlockedSorted()
	{
		return Doctrine_Core::getTable('WebUser')
			->createQuery('wu')
			->where('wu.is_enabled <> 1')
			->select()
			->orderBy('wu.login')
			->execute();
	}

  /**
   * Проверяет, разрешено ли пользователю указанное действие вообще или с указанным объектом.
   * Также возвращает положительный результат, если пользователь обладает правом супер-админа.
   *
   * @param   integer   $permissionId   Ключ проверяемого действия
   * @param   integer   $filterId       Фильтр конкретного объекта
   * @return  boolean
   */
  public function can($permissionId, $filterId)
  {
    foreach ($this->grantedPermissions as $grantedPermission)
    {
      if ((($grantedPermission->permission_id == $permissionId)
           || ($grantedPermission->permission_id == Permission::ROOT))
          && (($grantedPermission->filter_id == $filterId)
              || ($grantedPermission->filter_id == 0))
          && ($grantedPermission->deny == 0))
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Проверяет, разрешено ли пользователю указанное действие вообще или с указанным объектом.
   * Проверяет именно указанное право, для проверки с учетом админа - can.
   *
   * @param   integer   $permissionId   Ключ проверяемого действия
   * @param   integer   $filterId       Фильтр конкретного объекта
   * @return  boolean
   */
  public function canExact($permissionId, $filterId)
  {
    foreach ($this->grantedPermissions as $grantedPermission)
    {
      if (($grantedPermission->permission_id == $permissionId)
          && (($grantedPermission->filter_id == $filterId)
              || ($grantedPermission->filter_id == 0))
          && ($grantedPermission->deny == 0))
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Проверяет, запрещено ли пользователю указанное действие вообще или с указанным объектом.
   * Всегда проверяет именно указанное право, так как общего "супер-запрета" не бывает.
   * ВАЖНО! Не является эквивалентом !can, а проверяет явный признак запрета.
   *
   * @param   integer   $permissionId   Ключ проверяемого действия
   * @param   integer   $filterId       Фильтр конкретного объекта
   * @return  boolean
   */
  public function cannot($permissionId, $filterId)
  {
    $res = new Doctrine_Collection('GrantedPermission');
    foreach ($this->grantedPermissions as $grantedPermission)
    {
      if (($grantedPermission->permission_id == $permissionId)
          && (($grantedPermission->filter_id == $filterId)
              || ($grantedPermission->filter_id == 0))
          && ($grantedPermission->deny != 0))
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Разрешает пользователю выполнять действие вообще или с указанным объектом.
   * Если пользователю действие явно запрещено - возвращает ошибку.
   * Если исполнитель не имеет права управлять разрешениями - возвращает ошибку.
   *
   * @param   Permission  $permission  Право
   * @param   integer     $filterId    Фильтр конкретного объекта
   * @param   WebUser     $actor       Учетная запись исполнителя
   * @return  mixed                    true если все в порядке, иначе описание ошибки
   */
  public function grant(Permission $permission, $filterId, WebUser $actor)
  {
    //Управлять правами может только уполномоченный
    if (!$actor->can(Permission::PERMISSION_MODER, $this->id))
    {
      return Utils::cannotMessage($actor->getName(), Permission::byId(Permission::PERMISSION_MODER)->description);
    }
    if ($this->cannot($permission->id, $filterId))
    {
      return 'Нельзя разрешить пользователю '.$this->getName().' '.$permission->description.', так как это ему явно запрещено.';
    }    
    return $this->addPermission($permission, $filterId, false);
  }

  /**
   * Запрещает пользователю выполнять действие вообще или с указанным объектом.
   * Если пользователю действие явно разрешено - возвращает ошибку.
   * Если исполнитель не имеет права управлять разрешениями - возвращает ошибку.
   *
   * @param   Permission  $permission  Право
   * @param   integer     $filterId    Фильтр конкретного объекта
   * @param   WebUser     $actor       Учетная запись исполнителя
   * @return  mixed                    true если все в порядке, иначе описание ошибки
   */
  public function deny(Permission $permission, $filterId, WebUser $actor)
  {
    //Управлять правами может только уполномоченный
    if (!$actor->can(Permission::PERMISSION_MODER, $this->id))
    {
      return Utils::cannotMessage($actor->getName(), Permission::byId(Permission::PERMISSION_MODER)->description);
    }
/*    if ($this->cannot($permission->id, $filterId))
    {
      //Запрет уже есть.
      return true;
    }*/
    if ($this->canExact($permission->id, $filterId))
    {
      return 'Нельзя запретить пользователю '.$this->getName().' '.$permission->description.', так как это ему явно разрешено.';
    }
    return $this->addPermission($permission, $filterId, true);
  }

  /**
   * Отзывает разрешение или запрет пользователю выполнять действие вообще или с указанным объектом.
   * Если исполнитель не имеет права управлять разрешениями - возвращает ошибку.
   *
   * @param   Permission  $permission  Право
   * @param   integer     $filterId    Фильтр конкретного объекта
   * @param   WebUser     $actor       Учетная запись исполнителя
   * @return  mixed                    true если все в порядке, иначе описание ошибки
   */
  public function revoke(Permission $permission, $filterId, WebUser $actor)
  {
    //Управлять правами может только уполномоченный
    if (!$actor->can(Permission::PERMISSION_MODER, $this->id))
    {
      return Utils::cannotMessage($actor->getName(), Permission::byId(Permission::PERMISSION_MODER)->description);
    }
    return $this->dropPermission($permission, $filterId);
  }

  /**
   * Проверяет, есть ли у пользователя какие-либо полномочия модерирования
   */
  public function hasSomeToModerate()
  {
    $isAdmin = $this->canExact(Permission::ROOT, 0);

    $isWebUserModer = $this->can(Permission::WEB_USER_MODER, 0);
    $isPermissionModer = $this->can(Permission::PERMISSION_MODER, 0);
    $isFullTeamModer = $this->can(Permission::TEAM_MODER, 0);
    $isFullGameModer = $this->can(Permission::GAME_MODER, 0);

    if ($isAdmin
        || $isWebUserModer
        || $isPermissionModer
        || $isFullTeamModer
        || $isFullGameModer)
    {
      return true;
    }
    
    $partialTeamModer = false;
    if ( ! $isFullTeamModer)
    {
      $teamModerationPermissionIds = Doctrine::getTable('GrantedPermission')
          ->createQuery('gp')->select('gp.filter_id')
          ->where('web_user_id = ?', $this->id)
          ->andWhere('permission_id = ?', Permission::TEAM_MODER)
          ->andWhere('deny <= 0')
          ->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
      $partialTeamModer = count($teamModerationPermissionIds) > 0;
    }

    $partialGameModer = false;
    if ( ! $isFullGameModer)
    {
      $gameModerationPermissionIds = Doctrine::getTable('GrantedPermission')
          ->createQuery('gp')->select('gp.filter_id')
          ->where('web_user_id = ?', $this->id)
          ->andWhere('permission_id = ?', Permission::GAME_MODER)
          ->andWhere('deny <= 0')
          ->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
      $partialGameModer = count($gameModerationPermissionIds) > 0;
    }

    return $partialTeamModer || $partialGameModer;
  }
  
  /**
   * Активирует учетную запись.
   * При успехе возвращает true, при неправильном ключе активации - false, в иных случах - строку с ошибкой.
   *
   * @param   string  $login  Пользователь
   * @param   string  $key    ключ активации
   * @return  mixed           True|false или строка с ошибкой.
   */
  public static function activate($login, $key)
  {
    $webUser = WebUser::byName($login);
    if (!$webUser)
    {
      return 'Пользователь '.$login.' не найден.';
    }
    if ($webUser->is_enabled)
    {
      // Учетная запись не отключена.
      return true;
    }
    else
    {
      // Если ключ активации у пользователя не назначен, то активация невозможна.
      if ( (trim($webUser->tag) != '') && ($key == trim($webUser->tag)) )
      {
        //Ключ активации правильный.
        $webUser->is_enabled = true;
        $webUser->tag = Utils::generateActivationKey();
        $webUser->save();
        return true;
      }
      else
      {
        //Ключ активации указан неверно.
        return false;
      }
    }
  }

  //// Self ////

  /**
   * Ищет запись о праве среди имеющихся у пользователя со строгим учетом фильтра.
   *
   * @param   Permission        $permission   Разрешение
   * @param   integer           $filterId     Фильтр
   * @return  grantedPermission               Или false, если не найдено
   */
  protected function findGrantedPermission(Permission $permission, $filterId)
  {
    $res = new Doctrine_Collection('GrantedPermission');
    foreach ($this->grantedPermissions as $grantedPermission)
    {
      if (($grantedPermission->permission_id == $permission->id)
          && ($grantedPermission->filter_id == $filterId))
      {
        $res->add($grantedPermission);
      }
    }
    return ($res->count() > 0) ? $res->getFirst() : false;    
  }

  /**
   * Создает новое разрешение для пользователя. Если оно уже есть - ничего не делает.
   * Не учитывает наличие более общих разрешений.
   *
   * @param   Permission  $permission   Разрешение
   * @param   integer     $filterId     Фильтр
   * @param   boolean     $deny         Признак запрета
   * @return  boolean                   Результат
   */
  protected function addPermission(Permission $permission, $filterId, $deny)
  {
    if ($res = $this->findGrantedPermission($permission, $filterId))
    {
      return 'У '.$this->login.' уже есть разрешение или запрет '.$permission->description.var_dump($res);
    }
    else
    {
      $newGrantedPermission = new GrantedPermission;
      $newGrantedPermission->web_user_id = $this->id;
      $newGrantedPermission->permission_id = $permission->id;
      $newGrantedPermission->filter_id = $filterId;
      $newGrantedPermission->deny = $deny;
      $this->grantedPermissions->add($newGrantedPermission);
      $this->save();
      return true;
    }
    
  }

  /**
   * Удаляет разрешение пользователя. Если его уже нет - ничего не делает.
   * Фильтр учитывается строго, т.е.:
   * - удаление общего права не убирает частные.
   * - удаление частного права не влиет на общее, если оно есть.
   *
   * @param   Permission  $permission   Разрешение
   * @param   integer     $filterId     Фильтр
   * @return  boolean                   Результат
   */
  protected function dropPermission(Permission $permission, $filterId)
  {
    if ($victim = $this->findGrantedPermission($permission, $filterId))
    {
      $victim->delete();
      return true;
    }
    else
    {
      return 'У '.$this->login.' нет разрешения или запрета '.$permission->description;
    }
    
  }

}