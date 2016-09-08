<?php
$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;
$showModeration = $sessionWebUser && $sessionWebUser->hasSomeToModerate();
?>

<div>
	<?php
		$items = array();
		$header = Region::byId($sf_user->getAttribute('region_id'))->name;

		if ( ! $sf_user->isAuthenticated())
		{
			$items = array(
				'Вход' => 'auth/login',
				'Регистрация' => 'auth/register'
			);
		}
		else
		{
			$items = array(
				$header => '/region/setCurrent',
				'Игры' => 'game/index',
				'Команды' => 'team/index',
				'Профиль' => 'webUser/show?id='.$sf_user->getAttribute('id'),
				'Участники' => 'webUser/index'
			);

			if ($showModeration)
			{
				$items = array_merge($items, array('Модерирование' =>'moderation/show'));
			};
		}

		include_partial('global/menu', array('activeItem' => '', 'headerItem' => $header, 'items' => $items));
	?>
</div>