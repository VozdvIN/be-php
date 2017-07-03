<?php
/*
$_activeItem - выделенный пункт
$_isAdmin -
$_isWebUserModer -
$_isFullTeamModer -
$_isFullGameModer -
*/
	include_partial(
		'global/menu',
		array(
			'activeItem' => $_activeItem,
			'items' => array(
				'Настройки' => '/moderation/settings',
				'Проекты' => '/moderation/regions',
				'Участники' => '/moderation/users',
				'Команды' => '/moderation/teams',
				'Игры' => '/moderation/games'
			),
			'itemsVisible' => array(
				'Настройки' => $_isAdmin,
				'Проекты' => $_isAdmin,
				'Участники' => $_isWebUserModer,
				'Команды' => $_isFullTeamModer,
				'Игры' => $_isFullGameModer
			)
		)
	);