<?php
/* Входные данные:
 * - $_team - команда
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Игры' => 'team/showAuthorsIndex?id='.$_team->id,
			'Заявки' => 'team/showAuthorsCreation?id='.$_team->id
		)
	));
?>