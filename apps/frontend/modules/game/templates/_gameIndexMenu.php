<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => 'Игры',
		'backUrl' => '/home/index',
		'items' => array(
			'Игры' => 'game/index',
			'Игрок' => 'game/indexPlayer',
			'Автор' => 'game/indexAuthor',
			'Анонсы' => 'game/indexAnnounced',
			'Активные' => 'game/indexActive',
			'Завершены' => 'game/indexArchived'
		)
	));
?>