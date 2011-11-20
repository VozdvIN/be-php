<?php

/**
 * Region
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    sf
 * @subpackage model
 * @author     VozdvIN
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Region extends BaseRegion implements IStored
{
  
  const DEFAULT_REGION = 1;
  
  //// IStored ////
  
  public static function all()
  {
    return Utils::all('Region');
  }
  
  public static function byId($id)
  {
    return Utils::byId('Region', $id);
  }
  
}