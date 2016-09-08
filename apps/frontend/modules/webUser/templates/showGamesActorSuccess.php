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
			'_activeItem' => 'Организатор'
		)
	)
?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>

<?php if ($_games->count() == 0): ?>
<p>
	Пользователь не принимал участия в организации игр.
</p>
<?php else: ?>
<table class="no-border wide">
	<thead>
		<th>&nbsp;</th>
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
			<td>
			<?php if ($game->isActor($_webUser->getRawValue())): ?>
				<span class="warn">Автор</span>
			<?php else: ?>
				<span>Агент</span>
			<?php endif; ?>
			</td>
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

<p class="lf-before">
	Поданы заявки на создание игр:
</p>
<?php if ($_gameCreateRequests->count() > 0): ?>
<table class="no-border wide">
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
			<td>
				<?php if ($gameCreateRequest->canBeManaged($_webUser->getRawValue())): ?>
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'gameCreateRequest/delete?id='.$gameCreateRequest->id, array('method' => 'post')); ?></span>
				<?php else: ?>
				&nbsp;
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p>
	<span class="info info-bg pad-box box"><?php echo link_to('Создать игру', 'gameCreateRequest/newManual'); ?></span>
</p>