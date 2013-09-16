<?php

/**
 * Интерфейс для сущностей, для которых имеет значение игровой проект
 * 
 * @author brain
 */
interface IRegion
{

  /**
   * Возвращает коллекцию объектов, у которых игровой проект равен указанному.
   * Если передан не экземпляр Region или игровой проект по умолчанию - возвращает все.
   * 
   * @param   mixed               $region   Требуемый игровой проект
   * @return  Doctrine_Collection
   */
  public static function byRegion( $region);
  
  /**
   * Возвращает игровой проект объекта. Если он не указан, то вернет игровой проект
   * по умолчанию.
   * 
   * @return  Doctrine_Record
   */
  public function getRegionSafe();
  
}

?>
