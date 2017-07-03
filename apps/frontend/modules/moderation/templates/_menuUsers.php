<?php
/*
$_activeItem - выделенный пункт
*/
	include_partial(
		'global/menu',
		array(
			'activeItem' => $_activeItem,
			'items' => array(
				'Все' => '/moderation/users',
				'Блокированные' => '/moderation/usersBlocked',
			)
		)
	);