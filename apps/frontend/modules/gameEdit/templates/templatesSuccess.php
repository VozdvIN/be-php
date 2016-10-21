<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Шаблоны')); ?>

<table class="no-border">
	<?php if ($_canManage || $_isModerator): ?>
	<thead>
		<tr><td colspan="2"><span class="button"><?php echo link_to('Редактировать', 'gameEdit/templatesEdit?id='.$_game->id) ?></span></td></tr>
	</thead>
	<?php endif; ?>
	<tbody>
		<tr><th>Длительность задания:</th><td><?php echo Timing::intervalToStr($_game->time_per_task*60) ?></td></tr>
		<tr><th>Интервал подсказок:</th><td><?php echo Timing::intervalToStr($_game->time_per_tip*60) ?></td></tr>
		<tr><th>Ошибок, не более:</th><td><?php echo $_game->try_count.' за задание' ?></td></tr>
		<tr><th>Название формулировки:</th><td><?php echo $_game->task_define_default_name ?></td></tr>
		<tr><th>Префикс подсказки:</th><td><?php echo $_game->task_tip_prefix ?></td></tr>
	</tbody>
</table>