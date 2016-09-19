<?php include_partial('indexMenu', array( '_game' => $_game, '_activeItem' => 'Активные')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	В текущем игровом проекте нет активных игр.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>Остановка</th>
		<th>Завершение</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td><?php if ($game->status == Game::GAME_FINISHED): ?><span class="warn">Финишировала</span><?php else: ?>&nbsp;<?php endif; ?></td>
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
