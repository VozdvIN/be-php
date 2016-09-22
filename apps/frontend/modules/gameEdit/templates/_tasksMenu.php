<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Список' => 'gameEdit/tasks?id='.$_game->id,
			'Приоритеты' => 'gameEdit/tasksWeights?id='.$_game->id,
			'Переходы' => 'gameEdit/tasksConstraints?id='.$_game->id,
			'Фильтры' => 'gameEdit/tasksTransitions?id='.$_game->id
		)
	));
?>
