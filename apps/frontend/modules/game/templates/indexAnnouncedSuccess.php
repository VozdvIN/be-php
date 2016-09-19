<?php include_partial('indexMenu', array('_game' => $_game, '_activeItem' => 'Анонсы')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	В текущем игровом проекте нет анонсированных игр.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></td>
			<td><?php echo $game->describeNearestEvent(); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p class="info">
	Показаны игры только текущего игрового проекта.
</p>
