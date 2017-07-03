<?php include_partial('breadcrumbs') ?>

<?php include_partial('menu', array(
	'_activeItem' => 'Настройки',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<table class="no-border">
	<tbody>
		<tr><th>Быстрая регистрация:</th><td><?php echo $_settings->fast_user_register ? 'разрешена' : 'нет' ?></td></tr>
		<tr><th>Быстрое создание команд:</th><td><?php echo $_settings->fast_team_create ? 'разрешено' : 'нет' ?></td></tr>
		<tr><th>Создание команд по почте:</th><td><?php echo $_settings->email_team_create ? 'разрешено' : 'нет' ?></td></tr>
		<tr><th>Создание игр по почте:</th><td><?php echo $_settings->email_game_create ? 'разрешено' : 'нет' ?></td></tr>
	</tbody>
	<tfoot>
		<tr><td colspan="2"><span class="button-info"><?php echo link_to('Редактировать', 'moderation/settingsEdit'); ?></span></td></tr>
	</tfoot>
</table>

<h3>Для справок</h3>

<h4>Реквизиты сайта</h4>
<table class="no-border">
	<tbody>
		<tr><th>Название:</th><td><?php echo SiteSettings::SITE_NAME ?></td></tr>
		<tr><th>Домен:</th><td><?php echo SiteSettings::SITE_DOMAIN ?></td></tr>
		<tr><th>Адрес для связи:</th><td><?php echo SiteSettings::ADMIN_EMAIL_ADDR ?></td></tr>
	</tbody>
</table>
<p class="info">
	Редактирование выполняется через файл конфигурации сайта.
</p>

<h4>Отправка уведомлений</h4>
<table class="no-border">
	<tbody>
		<tr><th>Обратный адрес:</th><td><?php echo SiteSettings::NOTIFY_EMAIL_ADDR ?></td></tr>
		<tr><th>SMTP-сервер:</th><td><?php echo SiteSettings::NOTIFY_SMTP_HOST ?></td></tr>
		<tr><th>Порт:</th><td><?php echo SiteSettings::NOTIFY_SMTP_PORT ?></td></tr>
		<tr><th>Шифрование:</th><td><?php echo SiteSettings::NOTIFY_SMTP_SECURITY ?></td></tr>
		<tr><th>Аккаунт:</th><td><?php echo SiteSettings::NOTIFY_SMTP_LOGIN ?></td></tr>
		<tr><th>Пароль:</th><td>*****</td></tr>
	</tbody>
</table>
<p class="info">
	Редактирование выполняется через файл конфигурации сайта.
</p>
<p>
	<span class="button-info"><?php echo link_to('Тестовое уведомление на почту для связи', 'moderation/SMTPTest'); ?>
</p>
