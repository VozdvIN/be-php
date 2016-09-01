<?php
	include_partial(
		'gameIndexMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Активные',
			'_isGameModerator' => $_isGameModerator
		)
	)
?>

<?php if ($_games->count() == 0): ?>
<p class="info">
	Игр не обнаружено.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>Закончится</th>
		<th>Подведение итогов</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
			<td><?php if ($game->status == Game::GAME_FINISHED): ?><span class="warn">Финишировала</span><?php else: ?>&nbsp;<?php endif; ?></td>
			<td><?php echo $game->stop_datetime; ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>