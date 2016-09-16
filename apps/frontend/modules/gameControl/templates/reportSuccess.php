<h2>Результаты игры <?php echo $_game->name ?></h2>
<p>
	<span class="button"><?php echo link_to('Афиша', 'game/info?id='.$_game->id); ?></span>
</p>
<?php include_component('gameControl','results', array('gameId' => $_game->id)) ?>

<h3>Телеметрия</h3>
<?php include_component('gameControl', 'report', array('gameId' => $_game->id)); ?>
