<?php
/* Входные данные:
 * - $_webUser - агкета пользователя
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $_webUser->login,
		'items' => array(
			'Участники' => 'webUser/index',
			$_webUser->login => 'webUser/show?id='.$_webUser->id,
			'Права' => 'webUser/showPermissions?id='.$_webUser->id,
			'Действия' => 'webUser/showActions?id='.$_webUser->id
		)
	));
?>