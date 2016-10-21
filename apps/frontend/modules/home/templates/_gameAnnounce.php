<?php
/* Входные параметры:
 * - Game $game - игра
 * - boolean $_isAuth - авторизован ли пользователь.
 * - boolean $_showRegions - показывать или нет игровые проекты
 */
$region = $game->getRegionSafe();
?>
<div>
	<h4>
		<?php
			echo ($_isAuth ? link_to($game->name, 'game/show?id='.$game->id) : $game->name)
				.(($region->id != Region::DEFAULT_REGION) ? ('&nbsp;('.$game->getRegionSafe()->name.')') : '');
		?>
	</h4>
	<article>
		<?php echo Utils::decodeBB($game->short_info) ?>
	</article>
</div>
