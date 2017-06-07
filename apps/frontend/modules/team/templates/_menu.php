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
			'Данные' => 'team/show?id='.$_team->id,
			'Состав' => 'team/showCrewIndex?id='.$_team->id,
			'Игры' => 'team/showGames?id='.$_team->id,
			'Организация' => 'team/showAuthorsIndex?id='.$_team->id
		)
	));
?>