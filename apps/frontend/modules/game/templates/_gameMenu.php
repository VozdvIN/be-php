<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<h2>Игра <?php echo $_game->name ?></h2>

<p>
	<span class="pad-box box"><?php echo link_to('Афиша', 'game/info?id='.$_game->id, array('target' => '_blank')); ?></span>
	<span class="pad-box box"><?php echo link_to('Проведение', 'gameControl/pilot?id='.$_game->id, array('target' => '_blank')); ?></span>
	<span class="pad-box box"><?php echo link_to('Итоги', 'gameControl/report?id='.$_game->id, array('target' => '_blank')); ?></span>
</p>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Информация' => 'game/promo?id='.$_game->id,
			'Регистрация' => 'game/teams?id='.$_game->id,
			'Параметры' => 'game/settings?id='.$_game->id,
			'Шаблоны' => 'game/templates?id='.$_game->id,
			'Задания' => 'game/tasks?id='.$_game->id,
		)
	));
?>