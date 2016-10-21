<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Параметры')); ?>

<table class="no-border">
	<?php if ($_canManage || $_isModerator): ?>
	<thead>
		<tr><td colspan="2"><span class="button"><?php echo link_to('Редактировать', 'gameEdit/settingsEdit?id='.$_game->id) ?></span></td></tr>
	</thead>
	<?php endif; ?>
	<tbody>
		<tr><th>Интервал пересчета:</th><td><?php echo Timing::intervalToStr($_game->update_interval) ?></td></tr>
		<tr><th>Максимальная задержка:</th><td><?php echo Timing::intervalToStr($_game->update_interval_max) ?></td></tr>
		<tr><th>Пересчет командами:</th><td><?php echo $_game->teams_can_update ? 'разрешен' : 'нет' ?></td></tr>
	</tbody>
</table>