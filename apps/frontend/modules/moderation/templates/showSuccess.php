<h2>Модерирование</h2>

<?php if ($_isAdmin): ?>

<span class="pad-box box"><?php echo link_to('Управление игровыми проектами', 'region/index') ?></span>

<table class="no-border">
	<tbody>
		<tr><th colspan="2"><h4>Реквизиты сайта</h4></th></tr>
		<tr><th>Название сайта:</th><td><?php echo SiteSettings::SITE_NAME ?></td></tr>
		<tr><th>Домен сайта:</th><td><?php echo SiteSettings::SITE_DOMAIN ?></td></tr>
		<tr><th>Адрес администраторов:</th><td><?php echo SiteSettings::ADMIN_EMAIL_ADDR ?></td></tr>
		<tr><th colspan="2"><h4>Модерация</h4></th></tr>
		<tr><th>Создание команд по почте:</th><td><?php echo $_settings->email_team_create ? 'разрешено' : 'нет' ?></td></tr>
		<tr><th>Создание игр по почте:</th><td><?php echo $_settings->email_game_create ? 'разрешено' : 'нет' ?></td></tr>
		<tr><th>Быстрое создание команд:</th><td><?php echo $_settings->fast_team_create ? 'разрешено' : 'нет' ?></td></tr>
		<tr><th>Быстрая регистрация:</th><td><?php echo $_settings->fast_user_register ? 'разрешена' : 'нет' ?></td></tr>
		<tr><th colspan="2"><h4>Отправка уведомлений</h4></th></tr>
		<tr><th>Обратный адрес:</th><td><?php echo SiteSettings::NOTIFY_EMAIL_ADDR ?></td></tr>
		<tr><th>SMTP-сервер:</th><td><?php echo SiteSettings::NOTIFY_SMTP_HOST ?></td></tr>
		<tr><th>Порт:</th><td><?php echo SiteSettings::NOTIFY_SMTP_PORT ?></td></tr>
		<tr><th>Шифрование:</th><td><?php echo SiteSettings::NOTIFY_SMTP_SECURITY ?></td></tr>
		<tr><th>Аккаунт:</th><td><?php echo SiteSettings::NOTIFY_SMTP_LOGIN ?></td></tr>
		<tr><th>Пароль:</th><td>(см. файл конфигурации сайта)</td></tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'moderation/edit'); ?></span>
				<span class="info info-bg pad-box box"><?php echo link_to('Тестовое уведомление на '.SiteSettings::ADMIN_EMAIL_ADDR, 'moderation/SMTPTest'); ?></span>
			</td>
		</tr>
	</tfoot>
</table>

<?php endif ?>

<?php if ($_isWebUserModer): ?>
<h3>Пользователи</h3>
<p>
	Вы можете управлять анкетой <?php echo link_to('любого пользователя', 'webUser/index', array('target' => '_blank'))?>.
</p>
<?php	if ($_isPermissionModer): ?>
<p>
	Вы также можете управлять полномочиями пользователей.
</p>
<?php	endif ?>
<?php endif ?>

<?php if ($_isFullTeamModer): ?>
<h3>Команды</h3>
<p>
	Вы можете управлять <?php echo link_to('любой командой', 'team/index', array('target' => '_blank'))?>.
</p>
<p>
	Вы также можете управлять <?php echo link_to('заявками на создание команд', 'team/index', array('target' => '_blank'))?>.
</p>
<?php elseif ($_teamsUnderModeration->count() > 0): ?>
<h3>Команды</h3>
<ul>
	<?php foreach ($_teamsUnderModeration as $team): ?>
	<li><?php echo link_to($team->name, 'team/show?id='.$team->id) ?></li>
	<?php endforeach ?>
</ul>
<?php endif ?>

<?php if ($_isFullGameModer): ?>
<h3>Игры</h3>
<p>
	Вы можете управлять <?php echo link_to('любой игрой', 'game/index', array('target' => '_blank'))?>.
</p>
<?php elseif ($_gamesUnderModeration->count() > 0): ?>
<h3>Игры</h3>
<ul>
	<?php foreach ($_gamesUnderModeration as $game): ?>
	<li><?php echo link_to($game->name, 'game/promo?id='.$game->id) ?></li>
	<?php endforeach ?>
</ul>
<?php endif ?>

<?php if ($_isFullArticleModer): ?>
<h3>Статьи</h3>
<p>
	Вы можете редактировать <?php echo link_to('любую статью', 'article/index', array('target' => '_blank'))?>.
</p>
<?php elseif ($_articlesUnderModeration->count() > 0): ?>
<h3>Статьи</h3>
<ul>
	<?php foreach ($_articlesUnderModeration as $article): ?>
	<li><?php echo link_to($article->name, 'article/show?id='.$article->id) ?></li>
	<?php endforeach ?>
</ul>
<?php endif ?>
