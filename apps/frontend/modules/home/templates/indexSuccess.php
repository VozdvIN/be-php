<div><!--
 --><div style="display: inline-block; margin-right: 3px">
		<a href="/home/index" style="display: inline-block">
			<img src="/images/logo.png" alt="<?php echo SiteSettings::SITE_NAME ?>" />
		</a>
	</div><!--
 --><div style="display: inline-block;">
		<section>
			<?php include './config/layout/header.html'; ?>
		</section>
	</div>
</div>

<div>
	<span class="button"><?php echo link_to('Проект:', '/region/setCurrent'); ?></span>
	&nbsp;<h2 style="display: inline-block; margin-right: 3px; padding-left: 0"><?php echo $_currentRegion->name ?></h2>
</div>

<?php
	$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;
	include_partial(
		'global/menu',
		array(
			'activeItem' => '',
			'items' => array(
				'Вход' => 'auth/login',
				'Регистрация' => 'auth/register',
				'Игры' => 'game/index',
				'Команды' => 'team/index',
				'Профиль' => 'webUser/show?id='.$sf_user->getAttribute('id'),
				'Участники' => 'webUser/index',
				'Модерация' => 'moderation/show'
			),
			'itemsVisible' => array(
				'Вход' => ! $sessionWebUser,
				'Регистрация' =>  ! $sessionWebUser,
				'Игры' => $sessionWebUser,
				'Команды' => $sessionWebUser,
				'Профиль' => $sessionWebUser,
				'Участники' => $sessionWebUser,
				'Модерация' => $sessionWebUser && $sessionWebUser->hasSomeToModerate(),
			)
		)
	);
?>

<div style="width: 100%"><!--
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
	</div>
</div>