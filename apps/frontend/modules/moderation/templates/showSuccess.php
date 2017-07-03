<?php include_partial('breadcrumbs') ?>

<?php include_partial('menu', array(
	'_activeItem' => '',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<span class="button"><?php echo link_to('Ваши команды', 'webUser/showTeamsLeader?id='.$_webUser->id) ?></span>
<span class="button"><?php echo link_to('Ваши игры', 'webUser/showGamesActor?id='.$_webUser->id) ?></span>