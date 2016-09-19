<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 * _ $_editable - отображать ссылку на редактор
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $_game->name,
		'items' => array(
			'&nbsp;&#094;&nbsp;' => 'game/index',
			$_game->name => 'game/show?id='.$_game->id,
			'Команды' => 'game/showTeams?id='.$_game->id,
			'Итоги' => 'game/showResults?id='.$_game->id,
			'Редактор'.Utils::CROSS_PAGE_LINK_MARKER => 'gameEdit/promo?id='.$_game->id
		),
		'itemsVisible' => array(
			'Итоги' => $_game->status >= Game::GAME_ARCHIVED,
			'Редактор'.Utils::CROSS_PAGE_LINK_MARKER => $_editable
		)
	));
?>