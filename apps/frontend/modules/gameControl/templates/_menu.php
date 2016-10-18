<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	$header = $_game->name.' (Управление)';
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $header,
		'items' => array(
			Utils::MENU_BACK_BUTTON_TITLE => 'gameEdit/promo?id='.$_game->id,
			$header => 'gameControl/state?id='.$_game->id,
			'Задания' => 'gameControl/tasks?id='.$_game->id,
			'Маршруты' => 'gameControl/routes?id='.$_game->id,
			'Ответы' => 'gameControl/answers?id='.$_game->id,
			'Карта' => 'gameControl/overview?id='.$_game->id,
		)
	));
?>