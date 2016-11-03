<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	$header = $_game->name.' (Редактор)'; // TODO: Здесь не написать &nbsp; потому что в global/menu он каким-то чудом просто в пробел превратиться.
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $header,
		'items' => array(
			Utils::MENU_BACK_BUTTON_TITLE => (($_activeItem == $header) ? 'game/show?id='.$_game->id : 'gameEdit/promo?id='.$_game->id),
			$header => 'gameEdit/promo?id='.$_game->id,
			'Команды' => 'gameEdit/teams?id='.$_game->id,
			'Параметры' => 'gameEdit/settings?id='.$_game->id,
			'Шаблоны' => 'gameEdit/templates?id='.$_game->id,
			'Задания' => 'gameEdit/tasks?id='.$_game->id,
			'Управление'.Utils::CROSS_PAGE_LINK_MARKER => 'gameControl/state?id='.$_game->id,
		)
	));
?>