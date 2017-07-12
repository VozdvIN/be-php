<?php
	include_partial('global/menu',
		array('activeItem' => 'Модерация',
			'items' => array(Utils::MENU_BACK_BUTTON_TITLE => '/home/index', 'Модерация' => '/moderation/show'))
	);