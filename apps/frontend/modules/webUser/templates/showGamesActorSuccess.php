<?php include_partial('breadcrumbs', array('_webUser' => $_webUser)) ?>
<?php include_partial('menu', array('_activeItem' => 'Игры', '_webUser' => $_webUser, '_isSelf' => $_isSelf)) ?>
<?php include_partial('gamesMenu', array('_activeItem' => 'Организатор', '_webUser' => $_webUser)) ?>

<table class="no-border">
	<thead>
		<tr><td colspan="7"><span class="button-info"><?php echo link_to('Создать игру', 'gameCreateRequest/newManual'); ?></span></td></tr>
	</thead>
	<tbody>
		<?php if ($_games->count() == 0): ?>
		<tr>
			<td colspan="7">Пользователь не принимал участия в организации игр.<td>
		</tr>
		<?php else: ?>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td><?php if ($game->isActor($_webUser->getRawValue())): ?><span class="warn">Автор</span><?php else: ?><span>Агент</span><?php endif; ?></td>
			<td><?php if ($game->isActive()): ?><span class="info">Активна</span><?php else: ?>&nbsp;<?php endif; ?></td>
			<td><?php echo $game->describeNearestEvent(); ?></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>

<p class="info">
	Показаны игры из всех игровых проектов.
</p>