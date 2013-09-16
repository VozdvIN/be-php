<div class="menu">
  <ul>
    <?php if ($sf_user->isAuthenticated()): ?>
    <li><?php echo link_to('Команды', 'team/index') ?></li><li>
		<?php echo link_to('Игры', 'game/index') ?></li><li>
		<?php echo link_to('Участники', 'webUser/index') ?></li><?php
    $sessionWebUser = $sf_user->getSessionWebUser()->getRawValue();
    if ($sessionWebUser && $sessionWebUser->hasSomeToModerate())
    {
      echo "<li>".link_to('Модерирование', 'moderation/show')."</li>";
    }
    include_once ('customization/menuItemsCommon.php');
    include_once ('customization/menuItemsAuth.php');
    ?><?php else: ?><?php
    include_once ('customization/menuItemsNonAuth.php');
    include_once ('customization/menuItemsCommon.php');    
    ?><?php endif; ?>
  </ul>
</div>