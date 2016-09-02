<?php
/* Входные данные:
 * - $_game - игра
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Игры' => 'game/index',
			'Игрок' => 'game/indexPlayer',
			'Автор' => 'game/indexAuthor',
			'Анонсы' => 'game/indexAnnounced',
			'Активные' => 'game/indexActive',
			'Завершены' => 'game/indexArchived'
		),
		'useHeader' => true,
		'backUrl' => '/home/index'
	));
?>