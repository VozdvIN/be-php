<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Параметры',
			'_isModerator' => $_isModerator
		)
	);
	
	$retUrlRaw = Utils::encodeSafeUrl(url_for('game/teams?id='.$_game->id));
?>

<h3>Параметры</h3>

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
					<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'game/settingsEdit?id='.$_game->id) ?></span>
				</p>
				<?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>