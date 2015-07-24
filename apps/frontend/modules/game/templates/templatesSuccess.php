<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Шаблоны'
		)
	);
?>

<table class="no-border">
	<tbody>
		<tr>
			<th>Длительность задания:</th>
			<td><?php echo Timing::intervalToStr($_game->time_per_task*60) ?></td>
		</tr>
		<tr>
			<th>Интервал подсказок:</th>
			<td><?php echo Timing::intervalToStr($_game->time_per_tip*60) ?></td>
		</tr>
		<tr>
			<th>Ошибок, не более:</th>
			<td><?php echo $_game->try_count.' за задание' ?></td>
		</tr>
		<tr>
			<th>Название формулировки:</th>
			<td><?php echo $_game->task_define_default_name ?></td>
		</tr>
		<tr>
			<th>Префикс подсказки:</th>
			<td><?php echo $_game->task_tip_prefix ?></td>
		</tr>
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="2">
				<?php if ($_canManage || $_isModerator): ?>
				<p>
					<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'game/templatesEdit?id='.$_game->id) ?></span>
				</p>
				<?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>