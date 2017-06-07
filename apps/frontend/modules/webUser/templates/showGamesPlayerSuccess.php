<?php include_partial('breadcrumbs', array('_webUser' => $_webUser)) ?>
<?php include_partial('menu', array('_activeItem' => 'Игры', '_webUser' => $_webUser, '_isSelf' => $_isSelf)) ?>
<?php include_partial('gamesMenu', array('_activeItem' => 'Игрок', '_webUser' => $_webUser)) ?>

<?php if ($_games->count() == 0): ?>
<p>
	Пользователь не принимал участия ни в одной из игр.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td><?php if ($game->isActive()): ?><span class="warn">Активна</span><?php else: ?>&nbsp;<?php endif; ?></td>
			<td><?php echo $game->describeNearestEvent(); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>