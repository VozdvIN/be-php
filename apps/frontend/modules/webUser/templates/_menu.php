<?php
/* Входные данные:
 * - $_webUser - анкета пользователя
 * - $_activeItem - название активной вкладки
 * - $_isSelf - признак собственной анкеты текущего пользователя
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'headerItem' => $_webUser->login,
		'items' => array(
			Utils::MENU_BACK_BUTTON_TITLE => 'webUser/index',
			$_webUser->login => 'webUser/show?id='.$_webUser->id,
			'Команды' => 'webUser/showTeamsPlayer?id='.$_webUser->id,
			'Игры' => 'webUser/showGamesPlayer?id='.$_webUser->id,
			'Права' => 'webUser/showPermissions?id='.$_webUser->id,
			'Выход' => 'auth/logout'
		)
	));
?>

<?php if ($_isSelf): ?>
<p class="info">
	Это ваша анкета.
</p>
<?php endif ?>