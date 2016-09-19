<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Организация')) ?>

<?php include_partial('authorsMenu', array('_team' => $_team, '_activeItem' => 'Игры')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	Команда пока не организовывала игр.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>Брифинг</th>
		<th>Старт</th>
		<th>Стоп</th>
		<th>Итоги</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td>
				<?php if ($game->isActive()): ?>
				<span class="button"><?php echo link_to('К&nbsp;управлению', 'gameControl/pilot?id='.$game->id, array('target' => '_blank')) ?></span>
				<?php elseif ($game->status == Game::GAME_ARCHIVED): ?>
				<span class="button"><?php echo link_to('Итоги', 'gameControl/report?id='.$game->id, array('target' => '_blank')) ?></span>
				<?php else: ?>
				&nbsp;
				<?php endif; ?>
			</td>
			<td><?php echo $game->start_briefing_datetime; ?></td>
			<td><?php echo $game->start_datetime; ?></td>
			<td><?php echo $game->stop_datetime; ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
		</tr>
		<?php endforeach; ?>;
	</tbody>
</table>
<?php endif; ?>

<p class="info">
	Показаны игры из всех игровых проектов.
</p>
