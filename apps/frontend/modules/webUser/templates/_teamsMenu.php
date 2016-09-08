<?php
/* Входные данные:
 * - $_webUser - агкета пользователя
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Игрок' => 'webUser/showTeamsPlayer?id='.$_webUser->id,
			'Капитан' => 'webUser/showTeamsLeader?id='.$_webUser->id
		)
	));
?>