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
			Utils::MENU_BACK_BUTTON_TITLE => (($_activeItem == 'Игры') ? '/home/index' : 'game/index'),
			'Игры' => 'game/index',
			'Анонсы' => 'game/indexAnnounced',
			'Активные' => 'game/indexActive',
			'Завершены' => 'game/indexArchived'
		)
	));
?>