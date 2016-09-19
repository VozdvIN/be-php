<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Организация')) ?>

<?php include_partial('authorsMenu', array('_team' => $_team, '_activeItem' => 'Игры')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	Команда пока не организовывала игр.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td>
				<?php if ($game->isActive()): ?>
				<span class="button"><?php echo link_to('К&nbsp;управлению', 'gameControl/pilot?id='.$game->id, array('target' => '_blank')) ?></span>
				<?php endif; ?>
			</td>
			<td><?php echo $game->describeNearestEvent(); ?></td>
		</tr>
		<?php endforeach; ?>;
	</tbody>
</table>
<?php endif; ?>

<p class="info">
	Показаны игры из всех игровых проектов.
</p>
