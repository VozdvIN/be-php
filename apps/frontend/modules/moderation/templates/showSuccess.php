<h2>Модерирование</h2>

<?php if ($_isAdmin): ?>
<p>
<?php echo decorate_span('safeAction', link_to('Управление игровыми проектами', 'region/index'))?>
</p>
<?php 
  render_h3_inline_begin('Системные настройки');
  echo ' '.decorate_span('safeAction', link_to('Редактировать', 'moderation/edit'));
  render_h3_inline_end();
?>

<h4>Реквизиты сайта</h4>
<?php
$width = get_text_block_size_ex('Создание команд по почте:');
render_named_line($width, 'Название сайта:', SiteSettings::SITE_NAME);
render_named_line($width, 'Домен сайта:', SiteSettings::SITE_DOMAIN);
render_named_line($width, 'Адрес администраторов:', SiteSettings::ADMIN_EMAIL_ADDR);
?>
<h4>Модерация</h4>
<?php
render_named_line($width, 'Создание команд по почте:', $_settings->email_team_create ? decorate_span('info', 'Разрешено') : 'Не разрешено');
render_named_line($width, 'Создание игр по почте:', $_settings->email_game_create ? decorate_span('info', 'Разрешено') : 'Не разрешено');
render_named_line($width, 'Быстрое создание команд:', $_settings->fast_team_create ? decorate_span('warn', 'Разрешено') : 'Не разрешено');
render_named_line($width, 'Быстрая регистрация:', $_settings->fast_user_register ? decorate_span('warn', 'Разрешена') : 'Не разрешена');
?>
<h4>Отправка уведомлений</h4>
<?php
render_named_line($width, 'Обратный адрес:', SiteSettings::NOTIFY_EMAIL_ADDR);
render_named_line($width, 'SMTP-сервер:', SiteSettings::NOTIFY_SMTP_HOST);
render_named_line($width, 'Порт:', SiteSettings::NOTIFY_SMTP_PORT);
render_named_line($width, 'Шифрование:', SiteSettings::NOTIFY_SMTP_SECURITY);
render_named_line($width, 'Аккаунт:', SiteSettings::NOTIFY_SMTP_LOGIN);
render_named_line($width, 'Пароль:', SiteSettings::NOTIFY_SMTP_PASSWORD);
?>
<p>
  <?php echo decorate_span('safeAction', link_to('Отправить тестовое уведомление на '.SiteSettings::ADMIN_EMAIL_ADDR, 'moderation/SMTPTest')) ?>
</p>
<?php endif ?>

<?php if ( ! $_isAdmin): ?>
<?php   if ($_isWebUserModer): ?>
<h3>Пользователи</h3>
<p>
  Вы можете управлять анкетой <?php echo link_to('любого пользователя', 'webUser/index', array('target' => '_blank'))?>.
</p>
<?php     if ($_isPermissionModer): ?>
<p>
  Вы также можете управлять полномочиями пользователей.
</p>
<?php     endif ?>
<?php   endif ?>

<?php   if ($_isFullTeamModer): ?>
<h3>Команды</h3>
<p>
  Вы можете управлять <?php echo link_to('любой командой', 'team/index', array('target' => '_blank'))?>.
</p>
<p>
  Вы также можете управлять <?php echo link_to('заявками на создание команд', 'team/index', array('target' => '_blank'))?>.
</p>
<?php   endif ?>
<?php   if (( ! $_isFullTeamModer) && ($_teamsUnderModeration->count() > 0)): ?>
<h3>Команды</h3>
<ul>
  <?php   foreach ($_teamsUnderModeration as $team): ?>
  <li><?php echo link_to($team->name, 'team/show?id='.$team->id) ?></li>
  <?php   endforeach ?>
</ul>
<?php   endif ?>

<?php   if ($_isFullGameModer): ?>
<h3>Игры</h3>
<p>
  Вы можете управлять <?php echo link_to('любой игрой', 'game/index', array('target' => '_blank'))?>.
</p>
<?php   endif ?>
<?php   if (( ! $_isFullGameModer) && ($_gamesUnderModeration->count() > 0)): ?>
<h3>Игры</h3>
<ul>
  <?php   foreach ($_gamesUnderModeration as $game): ?>
  <li><?php echo link_to($game->name, 'game/promo?id='.$game->id) ?></li>
  <?php   endforeach ?>
</ul>
<?php   endif ?>

<?php   if ($_isFullArticleModer): ?>
<h3>Статьи</h3>
<p>
  Вы можете редактировать <?php echo link_to('любую статью', 'article/index', array('target' => '_blank'))?>.
</p>
<?php   endif ?>
<?php   if (( ! $_isFullArticleModer) && ($_articlesUnderModeration->count() > 0)): ?>
<h3>Статьи</h3>
<ul>
  <?php   foreach ($_articlesUnderModeration as $article): ?>
  <li><?php echo link_to($article->name, 'article/show?id='.$article->id) ?></li>
  <?php   endforeach ?>
</ul>
<?php   endif ?>

<?php endif; ?>
