<?php
	$retUrlRaw = Utils::encodeSafeUrl(url_for('gameControl/stuart?id='.$_game->id));
	include_partial('header', array(
		'_game' => $_game,
		'_isManager' => $_isManager,
		'_retUrlRaw' => $retUrlRaw,
		'_activeTab' => 'Стюардесса'));
?>

<h3>Текущие результаты команд</h3>

<?php include_partial('results', array('_game' => $_game)) ?>

<p>
	<span class="pad-box box"><?php echo link_to('Подробно', 'gameControl/report?id='.$_game->id, array('target' => '_blank')) ?></span>
</p>