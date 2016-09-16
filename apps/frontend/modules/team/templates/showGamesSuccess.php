<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Игры')) ?>

<?php if ($_teamStates->count() == 0): ?>
<p>
	Команда не участвовала ни в одной из игр.
</p>
<?php else: ?>
<table class="no-border wide">
	<thead>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		<th>Брифинг</th>
		<th>Старт</th>
		<th>Стоп</th>
		<th>Итоги</th>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<?php $game = $teamState->Game; ?>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
			<td>
				<?php if ($game->isActive()): ?>
				<span class="button"><?php echo link_to('К&nbsp;заданию', 'play/task?id='.$teamState->id, array('target' => '_blank')) ?></span>
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
