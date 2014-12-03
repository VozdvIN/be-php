<?php
/* Входные параметры:
 * - Game $game - игра
 * - boolean $_isAuth - авторизован ли пользователь.
 * - boolean $_showRegions - показывать или нет игровые проекты
 */
?>
<div>
	<h3><?php echo $_isAuth ? link_to($game->name, 'game/show?id='.$game->id) : $game->name; ?></h3>
	<?php if ($_showRegions): ?>
	<h4><?php echo $game->getRegionSafe()->name; ?></h4>
	<?php endif; ?>
	<article>
		<?php echo Utils::decodeBB($game->short_info) ?>
	</article>
</div>
