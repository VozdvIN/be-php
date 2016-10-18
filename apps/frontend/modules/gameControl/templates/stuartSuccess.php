<?php
	include_partial('header', array(
		'_game' => $_game,
		'_isManager' => $_isManager,
		'_activeTab' => 'Стюардесса'));
?>

<h3>Текущие результаты команд</h3>

<?php include_component('gameControl','results', array('gameId' => $_game->id)) ?>

<p>
	<span class="button"><?php echo link_to('Подробно', 'gameControl/report?id='.$_game->id, array('target' => '_blank')) ?></span>
</p>