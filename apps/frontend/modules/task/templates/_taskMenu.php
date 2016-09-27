<?php
/* Входные данные:
 * - $_task - задание
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $_task->name,
		'items' => array(
			Utils::MENU_BACK_BUTTON_TITLE => 'gameEdit/tasks?id='.$_task->game_id,
			$_task->name => 'task/params?id='.$_task->id,
			'Подсказки' => 'task/tips?id='.$_task->id,
			'Ответы' => 'task/answers?id='.$_task->id,
			'Переходы' => 'task/constraints?id='.$_task->id,
			'Фильтры' => 'task/transitions?id='.$_task->id
		)
	));
?>