<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<h2>Игры</h2>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Игрок' => 'game/indexPlayer',
			'Автор' => 'game/indexAuthor',
			'Все' => 'game/index',
			'Анонсы' => 'game/indexAnnounced',
			'Активные' => 'game/indexActive',
			'Завершены' => 'game/indexArchived'
		)
	));
?>