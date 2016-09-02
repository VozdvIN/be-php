<?php
/* Входные данные:
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => 'Участники',
		'backUrl' => '/home/index',
		'items' => array(
			'Участники' => 'webUser/index'
		),
	));
?>