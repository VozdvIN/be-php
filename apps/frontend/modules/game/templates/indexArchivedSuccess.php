<?php include_partial('indexMenu', array('_game' => $_game, '_activeItem' => 'Завершены')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	В текущем игровом проекте нет завершенных игр.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<th>&nbsp;</th>
		<th>Завершена</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
			<td><span class="button"><?php echo link_to('Результаты', 'gameControl/report?id='.$game->id) ?></span></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p class="info">
	Показаны игры только текущего игрового проекта.
</p>
