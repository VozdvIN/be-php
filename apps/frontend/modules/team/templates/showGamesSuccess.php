<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Игры')) ?>

<?php if ($_teamStates->count() == 0): ?>
<p>
	Команда не участвовала ни в одной из игр.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<?php $game = $teamState->Game; ?>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td>
				<?php if ($game->isActive()): ?>
				<span class="button"><?php echo link_to('К&nbsp;заданию', 'play/task?id='.$teamState->id, array('target' => '_blank')) ?></span>
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
