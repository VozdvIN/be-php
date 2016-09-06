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
		'items' => array(
			Region::byId($sf_user->getAttribute('region_id'))->name => '/home/index',
			'Игры' => 'game/index',
			'Игрок' => 'game/indexPlayer',
			'Автор' => 'game/indexAuthor',
			'Анонсы' => 'game/indexAnnounced',
			'Активные' => 'game/indexActive',
			'Завершены' => 'game/indexArchived'
		)
	));
?>