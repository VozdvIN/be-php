<?php
/* Входные данные:
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => 'Команды',
		'items' => array(
			Utils::MENU_BACK_BUTTON_TITLE => '/home/index',
			'Команды' => 'team/index'
		),
	));
?>