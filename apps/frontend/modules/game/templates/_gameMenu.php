<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 * - $_isModerator - наличие прав модератора
 */
?>

<h2>Игра <?php echo $_game->name ?></h2>

<?php if ($_isModerator): ?>
<p>
	
</p>
<?php endif; ?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Афиша'=> 'game/info?id='.$_game->id,
			'Информация' => 'game/promo?id='.$_game->id,
			'Регистрация' => 'game/teams?id='.$_game->id,
			'Параметры' => 'game/settings?id='.$_game->id,
			'Шаблоны' => 'game/templates?id='.$_game->id,
			'Задания' => 'game/tasks?id='.$_game->id,
			'Проведение' => 'gameControl/pilot?id='.$_game->id
		)
	));
?>