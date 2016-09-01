<?php
	include_partial(
		'gameIndexMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Анонсы',
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
		<th>Брифинг</th>
		<th>Старт</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
			<td><?php echo $game->start_briefing_datetime; ?></td>
			<td><?php echo $game->start_datetime; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>