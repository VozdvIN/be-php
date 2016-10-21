<?php
/* Входные данные:
 * - $_activeItem - название активной вкладки
 * - $_teamState - состояние команды
 */
$viewName = 'task';
$viewName = ($_activeItem == 'Ответы') ? 'answers' : $viewName;
$viewName = ($_activeItem == 'История') ? 'stats' : $viewName;
?>
<div style="display: inline-block">
	<span class="button-info"><?php echo link_to('Обновить', 'play/'.$viewName.'?id='.$_teamState->id); ?></span>
</div>
<div style="display: inline-block; margin-left: 6px">
	<span><strong><?php echo $_teamState->Game->name ?></strong><br><?php echo $_teamState->Team->name ?></span>
</div>
<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Задание' => 'play/task?id='.$_teamState->id,
			'Ответы' => 'play/answers?id='.$_teamState->id,
			'История' => 'play/stats?id='.$_teamState->id,
		)
	));
?>
