<?php
/* $_activeItem - название активной вкладки
   $_webUser - пользователь
   $_isSelf - признак собственной анкеты */

	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Анкета' => 'webUser/show?id='.$_webUser->id,
			'Команды' => 'webUser/showTeamsPlayer?id='.$_webUser->id,
			'Игры' => 'webUser/showGamesPlayer?id='.$_webUser->id,
			'Права' => 'webUser/showPermissions?id='.$_webUser->id
		)
	));
?>

<?php if ($_isSelf): ?>
<p class="info">
	Это ваша анкета.
</p>
<?php endif ?>