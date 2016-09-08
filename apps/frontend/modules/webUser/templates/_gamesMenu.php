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
			'Игрок' => 'webUser/showGamesPlayer?id='.$_webUser->id,
			'Организатор' => 'webUser/showGamesActor?id='.$_webUser->id
		)
	));
?>