<?php
	include_partial(
		'gameIndexMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Завершены',
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
		<th>Итоги подведены</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
			<td><span class="pad pad-box box"><?php echo link_to('Результаты', 'gameControl/report?id='.$game->id) ?></span></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>