<div>
	<?php include './config/layout/header.html'; ?>
</div>

<?php
	$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;

	include_partial(
		'global/menu',
		array(
			'activeItem' => $_currentRegion->name,
			'items' => array(
				$_currentRegion->name => '/region/setCurrent',
				'Вход' => 'auth/login',
				'Регистрация' => 'auth/register',
				$sessionWebUser->login => 'webUser/show?id='.$sf_user->getAttribute('id'),
				'Выход' => 'auth/logout'
			),
			'itemsVisible' => array(
				'Вход' => ! $sessionWebUser,
				'Регистрация' => ! $sessionWebUser,
				$sessionWebUser->login => $sessionWebUser,
				'Выход' => $sessionWebUser
			)
		)
	);

	if ($sessionWebUser)
	{
		include_partial(
			'global/menu',
			array(
				'activeItem' => '',
				'items' => array(
					'Игры' => 'game/index',
					'Команды' => 'team/index',
					'Участники' => 'webUser/index',
					'Модерация' => 'moderation/show'
				),
				'itemsVisible' => array(
					'Модерация' => $sessionWebUser->hasSomeToModerate(),
				)
			)
		);
	}
?>

<!--
 --><div style="width: 100%"><!--
	 --><div style="display:inline-block; width: 100%">
			<div style="text-align: right; margin-right: 6px;">
				<article>
					<?php include './config/layout/main.html'; ?>
				</article>
			</div>
		</div><!--
--></div><!--
--><div class="border-top"><!--
	 --><div style="display: inline-block; width: 30%">
			<p>
				Время сервера: <?php include_partial('global/clock') ?>.
			</p>
			<p>
				Powered by <a href="http://beavengine.ru" target="_blank">Beaver's Engine</a>.
			</p>
		</div><!--
	 --><div style="display: inline-block; width: 70%;">
			<article>
				<?php include './config/layout/footer.html'; ?>
			</article>
		</div><!--
 --></div>