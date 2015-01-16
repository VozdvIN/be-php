<?php
/* Входные параметры:
 * - Game $game - игра
 * - boolean $_isAuth - авторизован ли пользователь.
 * - boolean $_showRegions - показывать или нет игровые проекты
 */
?>
<div>
	<h3><?php echo $_isAuth ? link_to($game->name, 'game/info?id='.$game->id) : $game->name; ?></h3>
	<h4><?php echo $game->getRegionSafe()->name; ?></h4>
	<article>
		<?php echo Utils::decodeBB($game->short_info) ?>
	</article>
</div>
