<?php
	include_partial(
		'menu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => 'Игры'
		)
	)
?>

<?php if ($_isSelf): ?>
<p class="info">
	Это ваша анкета.
</p>
<?php endif ?>

<?php
	include_partial(
		'gamesMenu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => 'Игрок'
		)
	)
?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>

<?php if ($_games->count() == 0): ?>
<p>
	Пользователь не принимал участия ни в одной из игр.
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
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
			<td><?php if ($game->isActive()): ?><span class="warn">Активна</span><?php else: ?>&nbsp;<?php endif; ?></td>
			<td><?php echo $game->start_briefing_datetime; ?></td>
			<td><?php echo $game->start_datetime; ?></td>
			<td><?php echo $game->stop_datetime; ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>