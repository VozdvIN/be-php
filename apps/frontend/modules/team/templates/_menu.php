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
			'Команды' => 'team/index',
			$_team->name => 'team/show?id='.$_team->id,
			'Состав' => 'team/showCrew?id='.$_team->id,
			'Игры' => 'team/showGameStates?id='.$_team->id,
			'Организация' => 'team/showGames?id='.$_team->id
		)
	));
?>