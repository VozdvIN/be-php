<?php
/* Входные данные:
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => 'Участники',
		'items' => array(
			'&nbsp;&#094;&nbsp;' => '/home/index',
			'Участники' => 'webUser/index'
		),
	));
?>