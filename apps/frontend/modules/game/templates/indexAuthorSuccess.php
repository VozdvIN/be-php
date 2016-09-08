<?php
	include_partial(
		'gameIndexMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Автор',
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
		<th>Брифинг</th>
		<th>Старт</th>
		<th>Стоп</th>
		<th>Итоги</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
			<td><?php if ($game->isActive()): ?><span class="info">Активна</span><?php else: ?>&nbsp;<?php endif; ?></td>
			<td><?php echo $game->start_briefing_datetime; ?></td>
			<td><?php echo $game->start_datetime; ?></td>
			<td><?php echo $game->stop_datetime; ?></td>
			<td><?php echo $game->finish_briefing_datetime; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p>
	Ваши заявки на создание игр:
</p>
<p>
	<span class="info info-bg pad-box box">
		<?php
		echo $_isGameModerator
			? link_to('Создать игру', 'game/new')
			: link_to('Подать заявку', 'gameCreateRequest/newManual');
		?>
	</span>
</p>
<?php if ($_gameCreateRequests->count() > 0): ?>
<table class="no-border">
	<thead>
		<tr>
			<th>Название</th>
			<th>Сообщение</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_gameCreateRequests as $gameCreateRequest): ?>
		<tr>
			<td><?php echo $gameCreateRequest->name; ?></td>
			<td><?php echo $gameCreateRequest->description; ?></td>
			<td><span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'gameCreateRequest/delete?id='.$gameCreateRequest->id, array('method' => 'post')); ?></span></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>