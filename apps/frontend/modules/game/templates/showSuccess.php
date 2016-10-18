<?php include_partial('menu', array('_game' => $_game, '_activeItem' => $_game->name, '_editable' => $_canManage)) ?>

<?php if (($_game->status <= Game::GAME_VERIFICATION) && $_canPostJoin): ?>
	<span class="button-info"><?php echo link_to('Подать заявку на участие', 'game/postJoinManual?id='.$_game->id, array('method' => 'post')); ?></span>
<?php endif ?>

<h1><?php echo $_game->name ?></h1>

<article>
	<?php echo Utils::decodeBB($_game->short_info) ?>
</article>

<table class="no-border">
	<tbody>
		<tr><th>Организаторы:</th><td><?php echo ($_game->team_id !== null) ? $_game->Team->name : $_game->getTeamBackupName() ?></td></tr>
		<tr><th>Проект:</th><td><?php echo $_game->getRegionSafe()->name ?></td></tr>
		<tr><th>Брифинг:</th><td><?php echo $_game->start_briefing_datetime ?></td></tr>
		<tr><th>Старт игры:</th><td><?php echo $_game->start_datetime ?></td></tr>
	</tbody>
</table>

<article>
	<?php echo Utils::decodeBB($_game->description) ?>
</article>

<table class="no-border">
	<tbody>
		<tr><th>Длительность:</th><td><?php echo Timing::intervalToStr($_game->time_per_game*60) ?></td></tr>
		<tr><th>Заданий:</th><td><?php echo $_game->tasks->count() ?></td></tr>
		<tr><th>Завершение:</th><td><?php echo $_game->stop_datetime ?></td></tr>
		<tr><th>Итоги:</th><td><?php echo $_game->finish_briefing_datetime ?></td></tr>
	</tbody>
</table>