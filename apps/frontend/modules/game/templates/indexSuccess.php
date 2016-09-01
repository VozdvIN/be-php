<?php
	include_partial(
		'gameIndexMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Все'
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
		<th>Статус</th>
		<th>Брифинг</th>
		<th>Старт</th>
		<th>Стоп</th>
		<th>Итоги</th>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/promo?id='.$game->id); ?></td>
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

<?php if ($_gameCreateRequests->count() > 0): ?>
<h3><?php echo $_isGameModerator ? 'Заявки' : 'Ваши заявки'; ?></h3>
<table class="no-border">
	<tbody>
		<?php foreach ($_gameCreateRequests as $gameCreateRequest): ?>
		<tr>
			<td><?php echo $gameCreateRequest->name; ?></td>
			<td><?php echo $gameCreateRequest->description; ?></td>
			<td><?php echo link_to($gameCreateRequest->Team->name, 'team/show?id='.$gameCreateRequest->team_id, array('target' => '_blank')); ?></td>
			<td>
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'gameCreateRequest/delete?id='.$gameCreateRequest->id, array('method' => 'post')); ?></span>
				<?php if ($_isGameModerator): ?>
				<span class="warn warn-bg pad-box box"><?php link_to('Создать', 'gameCreateRequest/acceptManual?id='.$gameCreateRequest->id, array('method' => 'post', 'confirm' => 'Подтвердить создание игры '.$gameCreateRequest->name.' ('.$gameCreateRequest->Team->name.' будут ее организаторами) ?')); ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>