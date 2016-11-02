<?php include_partial('indexMenu', array('_game' => $_game, '_activeItem' => 'Анонсы')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	В текущем игровом проекте нет анонсированных игр.
</p>
<?php else: ?>
	<?php foreach ($_games as $game): ?>
<div class="border-bottom">
	<h3><?php echo link_to($game->name, 'game/show?id='.$game->id); ?></h3>
	<p><?php echo $game->describeNearestEvent(); ?></p>
	<article><?php echo Utils::decodeBB($game->short_info); ?></article>
</div>
	<?php endforeach; ?>
<?php endif; ?>

<p class="info">
	Показаны игры только текущего игрового проекта.
</p>
