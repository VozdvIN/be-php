<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 * - $_isModerator - наличие прав модератора
 */
?>

<h2>Игра <?php echo $_game->name ?></h2>

<p>
	<span class="info info-bg pad-box box"><?php echo link_to('Проведение', 'gameControl/pilot?id='.$_game->id) ?></span>
	<?php if ($_isModerator): ?>
		<span class="danger danger-bg pad-box box"><?php echo link_to('Удалить игру', 'game/delete?id='.$_game->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить игру '.$_game->name.'?')) ?></span>
	<?php endif; ?>
</p>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Информация' => 'game/promo?id='.$_game->id,
			'Регистрация' => 'game/teams?id='.$_game->id,
			'Параметры' => 'game/settings?id='.$_game->id,
			'Шаблоны' => 'game/templates?id='.$_game->id,
			'Задания' => 'game/tasks?id='.$_game->id
		)
	));
?>