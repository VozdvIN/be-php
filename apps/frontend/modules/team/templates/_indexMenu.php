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
			'&nbsp;&#094;&nbsp;' => '/home/index',
			'Команды' => 'team/index'
		),
	));
?>