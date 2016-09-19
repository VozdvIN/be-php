<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => '',
		'items' => array(
			'Места' => 'game/showResults?id='.$_game->id,
			'Телеметрия' => 'game/showResultsDetails?id='.$_game->id
		)
	));
?>