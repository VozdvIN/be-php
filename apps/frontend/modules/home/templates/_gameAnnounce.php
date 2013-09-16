<?php
/* Входные параметры:
 * - Game $game - игра
 * - boolean $_isAuth - авторизован ли пользователь.
 * - boolean $_showRegions - показывать или нет регионы
 */
  $name = $_isAuth ? link_to($game->name, 'game/show?id='.$game->id) : $game->name;
  $formatedName = '<h3>'.$name.'</h3>';
  $region = $_showRegions ? '<h4>'.$game->getRegionSafe()->name.'</h4>' : '';
  $date = '<h5>'.$game->start_datetime.'</h5>';
  $info = '<div>'.Utils::decodeBB($game->short_info).'</div>';
  echo decorate_div('namedLineBox', $formatedName.$region.$date.$info);
?>
