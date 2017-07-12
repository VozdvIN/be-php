<?php
/*
$_activeItem - выделенный пункт
*/
	include_partial(
		'global/menu',
		array(
			'activeItem' => $_activeItem,
			'items' => array(
				'Существующие' => '/moderation/teams',
				'Заявки' => '/moderation/teamsCreateRequests',
			)
		)
	);