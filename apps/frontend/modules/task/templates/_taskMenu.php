<?php
/* Входные данные:
 * - $_task - задание
 * - $_activeItem - название активной вкладки
 */
?>

<?php include_partial('game/gameMenu', array('_game' => $_task->Game, '_activeItem' => 'Задания')) ?>

<h3>Задание &quot;<?php echo $_task->name ?>&quot;</h3>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Параметры'=> 'task/params?id='.$_task->id,
			'Подсказки' => 'task/tips?id='.$_task->id,
			'Ответы' => 'task/answers?id='.$_task->id,
			'Переходы' => 'task/constraints?id='.$_task->id,
			'Фильтры' => 'task/transitions?id='.$_task->id
		)
	));
?>