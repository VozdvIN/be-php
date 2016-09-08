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
			Region::byId($sf_user->getAttribute('region_id'))->name => '/home/index',
			'Команды' => 'team/index',
			'Рядовой' => 'team/indexPlayer',
			'Капитан' => 'team/indexLeader'
		),
	));
?>