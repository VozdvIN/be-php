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
			'&nbsp;&#094;&nbsp;' => '/home/index',
			'Игры' => 'game/index',
			'Анонсы' => 'game/indexAnnounced',
			'Активные' => 'game/indexActive',
			'Завершены' => 'game/indexArchived'
		)
	));
?>