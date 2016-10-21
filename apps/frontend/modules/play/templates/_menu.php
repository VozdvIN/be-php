<?php
/* Входные данные:
 * - $_activeItem - название активной вкладки
 * - $_teamState - состояние команды
 */
$viewName = 'task';
$viewName = ($_activeItem == 'Ответы') ? 'answers' : $viewName;
$viewName = ($_activeItem == 'История') ? 'stats' : $viewName;

include_partial('global/menu', 
	array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Задание' => 'play/task?id='.$_teamState->id,
			'Ответы' => 'play/answers?id='.$_teamState->id,
			'История' => 'play/stats?id='.$_teamState->id,
			'Обновить'.Utils::CROSS_PAGE_LINK_MARKER => 'play/'.$viewName.'?id='.$_teamState->id)
	)
);
?>
