<div>
	<?php
		$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;
		$header = Region::byId($sf_user->getAttribute('region_id'))->name;
		include_partial(
			'global/menu',
			array(
				'activeItem' => '',
				'headerItem' => $sessionWebUser ? $header : '',
				'items' => array(
					'Вход' => 'auth/login',
					'Регистрация' => 'auth/register',
					$header => '/region/setCurrent',
					'Игры' => 'game/index',
					'Команды' => 'team/index',
					'Профиль' => 'webUser/show?id='.$sf_user->getAttribute('id'),
					'Участники' => 'webUser/index',
					'Модерирование' => 'moderation/show'
				),
				'itemsVisible' => array(
					'Вход' => ! $sessionWebUser,
					'Регистрация' =>  ! $sessionWebUser,
					$header => $sessionWebUser,
					'Игры' => $sessionWebUser,
					'Команды' => $sessionWebUser,
					'Профиль' => $sessionWebUser,
					'Участники' => $sessionWebUser,
					'Модерирование' => $sessionWebUser && $sessionWebUser->hasSomeToModerate(),
				)
			)
		);
	?>
</div>