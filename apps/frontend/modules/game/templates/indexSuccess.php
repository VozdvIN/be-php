<?php include_partial('indexMenu', array('_game' => $_game, '_activeItem' => 'Игры')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	В текущем игровом проекте пока нет игр.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<th>&nbsp;</th>
		<th>Статус</th>
		<th>Брифинг</th>
		<th>Старт</th>
		<th>Завершение</th>
		<th>Итоги</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td><span class="<?php echo $game->cssForStatus(); ?>"><?php echo $game->describeStatus(); ?></span></td>
			<td><?php echo $game->start_briefing_datetime; ?></td>
			<td><?php echo $game->start_datetime; ?></td>
			<td><?php echo $game->stop_datetime; ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p class="info">
	Показаны игры только текущего игрового проекта.
</p>
