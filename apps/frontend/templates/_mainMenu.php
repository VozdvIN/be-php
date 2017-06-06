<?php
$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;
$showModeration = $sessionWebUser && $sessionWebUser->hasSomeToModerate();
?>

<div class="menu">
  <ul>
    <?php if ($sf_user->isAuthenticated()): ?>
      
    <li><?php echo link_to('Команды', 'team/index') ?></li>
    <li><?php echo link_to('Игры', 'game/index') ?></li>
    <li><?php echo link_to('Участники', 'webUser/index') ?></li>
    <?php if ($showModeration): ?>
    <li><?php echo link_to('Модерирование', 'moderation/show') ?></li>
    <?php endif; ?>
    <li><?php echo link_to('Статьи', 'article/by?name=Разделы') ?></li>
    <li><?php echo link_to('Выход', 'auth/logout') ?></li>
    
    <?php else: ?>

    <li><?php echo link_to('Вход', 'auth/login') ?></li>
    <li><?php echo link_to('Регистрация', 'auth/register') ?></li>
    
    <?php endif; ?>
  </ul>
</div>