<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Команды')); ?>

<p>
	Выберите команду для регистрации:
</p>

<ul>
	<?php foreach ($_teams as $team): ?>
	<li><span class="button"><?php echo link_to($team->getNormalName(), 'gameEdit/registerDo?id='.$_game->id.'&teamId='.$team->id); ?></span></li>
	<?php endforeach ?>
</ul>