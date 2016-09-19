<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Параметры'
		)
	);
?>

<table class="no-border">
	<tbody>
		<tr>
			<th>Интервал пересчета:</th>
			<td><?php echo Timing::intervalToStr($_game->update_interval) ?></td>
		</tr>
		<tr>
			<th>Максимальная задержка:</th>
			<td><?php echo Timing::intervalToStr($_game->update_interval_max) ?></td>
		</tr>
		<tr>
			<th>Пересчет командами:</th>
			<td><?php echo $_game->teams_can_update ? 'разрешен' : 'нет' ?></td>
		</tr>
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="2">
				<?php if ($_canManage || $_isModerator): ?>
				<p>
					<span class="button-info"><?php echo link_to('Редактировать', 'game/settingsEdit?id='.$_game->id) ?></span>
				</p>
				<?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>