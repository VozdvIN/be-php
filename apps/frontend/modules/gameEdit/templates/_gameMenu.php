<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<h2>Игра <?php echo $_game->name ?></h2>

<p>
	<span class="button"><?php echo link_to('Афиша', 'game/show?id='.$_game->id, array('target' => '_blank')); ?></span>
	<span class="button"><?php echo link_to('Проведение', 'gameControl/pilot?id='.$_game->id, array('target' => '_blank')); ?></span>
	<span class="button"><?php echo link_to('Итоги', 'gameControl/report?id='.$_game->id, array('target' => '_blank')); ?></span>
</p>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Информация' => 'gameEdit/promo?id='.$_game->id,
			'Регистрация' => 'gameEdit/teams?id='.$_game->id,
			'Параметры' => 'gameEdit/settings?id='.$_game->id,
			'Шаблоны' => 'gameEdit/templates?id='.$_game->id,
			'Задания' => 'gameEdit/tasks?id='.$_game->id,
		)
	));
?>