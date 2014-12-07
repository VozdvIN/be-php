<h2>Игра <?php echo $_game->name ?></h2>

<p>
	<span class="info info-bg pad-box box"><?php echo link_to('Состояние и управление', 'gameControl/pilot?id='.$_game->id) ?></span>
</p>

<?php
	$activeItem = '';
	if     ($_tab == 'props') $activeItem = 'Настройки';
	elseif ($_tab == 'teams') $activeItem = 'Регистрация команд';
	elseif ($_tab == 'tasks') $activeItem = 'Задания';

	include_partial('global/menu', array(
		'activeItem' => $activeItem,
		'items' => array(
			'Афиша' => 'game/info?id='.$_game->id,
			'Настройки' => 'game/show?id='.$_game->id.'&tab=props',
			'Регистрация команд' => 'game/show?id='.$_game->id.'&tab=teams',
			'Задания' => 'game/show?id='.$_game->id.'&tab=tasks'
		)
	));
?>

<?php
	$partial = null;
	if     ($_tab == 'props') $partial = 'gameProps';
	elseif ($_tab == 'teams') $partial = 'gameRegistration';
	elseif ($_tab == 'tasks') $partial = 'gameTasks';

	if (isset($partial))
	{
		include_partial($partial, array(
			'_game' => $_game,
			'_retUrlRaw' => Utils::encodeSafeUrl(url_for('game/show?id='.$_game->id.'&tab='.$_tab)),
			'_sessionCanManage' => $_sessionCanManage,
			'_sessionIsModerator' => $_sessionIsModerator,
			'_teamStates' => isset($_teamStates) ? $_teamStates : null,
			'_gameCandidates' => isset($_gameCandidates) ? $_gameCandidates : null,
			'_tasks' => isset($_tasks) ? $_tasks : null
		));
	}
?>