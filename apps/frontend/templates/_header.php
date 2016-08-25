<?php
$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;
$showModeration = $sessionWebUser && $sessionWebUser->hasSomeToModerate();
?>

<div class="border-bottom" style="min-height: 50px"><!--
 --><div style="display: inline-block;">
		<a href="/home/index" style="display: inline-block">
			<img src="/images/logo.png" alt="<?php echo SiteSettings::SITE_NAME ?>" />
		</a>
	</div><!--
 --><div style="display: inline-block; padding-left: 6px;">
		<h1 style="text-align: left; padding: 0 0 0 0;"><?php echo SiteSettings::SITE_NAME.' - '.Region::byId($sf_user->getAttribute('region_id'))->name ?></h1>
	</div><!--
 --><nav class="menu">
		<ul>
			<?php if ($sf_user->isAuthenticated()): ?>
			<li><?php echo link_to('Главная', '/home/index') ?></li><!--
		 --><li><?php echo link_to('Профиль', 'webUser/show?id='.$sf_user->getAttribute('id')) ?></li><!--
		 --><li><?php echo link_to('Проект', 'region/setCurrent?returl='.Utils::encodeSafeUrl($_SERVER['REQUEST_URI'])) ?></li><!--
		 --><li><?php echo link_to('Команды', 'team/index') ?></li><!--
		 --><li><?php echo link_to('Игры', 'game/index') ?></li><!--
		 --><li><?php echo link_to('Участники', 'webUser/index') ?></li><!--
			<?php	if ($showModeration): ?>
		 --><li><?php	echo link_to('Модерирование', 'moderation/show') ?></li><!--
			<?php	endif; ?>
		 --><li><?php echo link_to('Статьи', 'article/by?name=Разделы') ?></li><!--
		 --><li><?php echo link_to('Выход', 'auth/logout') ?></li><!--
			<?php else: ?>
		 --><li><?php echo link_to('Вход', 'auth/login') ?></li><!--
		 --><li><?php echo link_to('Регистрация', 'auth/register') ?></li><!--
			<?php endif; ?>
	 --></ul>
	</nav>
</div>