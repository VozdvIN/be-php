<?php include_partial('menu', array('_game' => $_game, '_activeTab' => 'Стюардесса')); ?>

<h3>Текущие результаты команд</h3>

<p>
	<span class="button"><?php echo link_to('Результаты', 'game/showResults?id='.$_game->id, array('target' => '_blank')) ?></span>
</p>

<p>
	<span class="button"><?php echo link_to('Телеметрия', 'game/showResultsDetails?id='.$_game->id, array('target' => '_blank')) ?></span>
</p>