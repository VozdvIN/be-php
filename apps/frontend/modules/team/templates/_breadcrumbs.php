<?php
/* $_team - команда */
	if (isset($_team))
	{
		include_partial('global/menu', array(
			'activeItem' => $_team->name,
			'items' => array(
				Utils::MENU_BACK_BUTTON_TITLE => 'home/index',
				'Команды' => 'team/index',
				$_team->name => 'team/show?id='.$_team->id
			)
		));
	}
	else
	{
		include_partial('global/menu', array(
			'activeItem' => 'Команды',
			'items' => array(
				Utils::MENU_BACK_BUTTON_TITLE => 'home/index',
				'Команды' => 'team/index'
			)
		));
	}
?>