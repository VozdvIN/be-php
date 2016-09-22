<?php
/* Входные данные:
 * - $_team - команда
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $_team->name,
		'items' => array(
			Utils::MENU_BACK_BUTTON_TITLE => 'team/index',
			$_team->name => 'team/show?id='.$_team->id,
			'Состав' => 'team/showCrewIndex?id='.$_team->id,
			'Игры' => 'team/showGames?id='.$_team->id,
			'Организация' => 'team/showAuthorsIndex?id='.$_team->id
		)
	));
?>