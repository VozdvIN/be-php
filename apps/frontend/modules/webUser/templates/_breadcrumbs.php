<?php
/* $_webUser - пользователь */
	if (isset($_webUser))
	{
		include_partial('global/menu', array(
			'activeItem' => $_webUser->login,
			'items' => array(
				Utils::MENU_BACK_BUTTON_TITLE => '/home/index',
				'Участники' => 'webUser/index',
				$_webUser->login => 'webUser/show?id='.$_webUser->id
			),
		));
	}
	else
	{
		include_partial('global/menu', array(
			'activeItem' => 'Участники',
			'items' => array(
				Utils::MENU_BACK_BUTTON_TITLE => '/home/index',
				'Участники' => 'webUser/index'
			),
		));
	}
?>