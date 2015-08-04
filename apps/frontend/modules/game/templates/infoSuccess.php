<?php
	$retUrlRaw = Utils::encodeSafeUrl('game/info?id='.$_game->id)
?>

<h1><?php echo $_game->name ?></h1>

<?php if ((($_canPostJoin) && ($_game->status < Game::GAME_ARCHIVED)) || $_canManage || $_isModerator): ?>
<p>
	<?php if (($_canPostJoin) && ($_game->status < Game::GAME_ARCHIVED)): ?>
		<span class="info info-bg pad-box box"><?php echo link_to('Подать заявку на участие', 'game/postJoinManual?id='.$_game->id.'&returl='.$retUrlRaw, array('method' => 'post')); ?></span>
	<?php endif ?>
	<?php if ($_canManage || $_isModerator): ?>
		<span class="pad-box box"><?php echo link_to('Редактор', 'game/promo?id='.$_game->id); ?></span>
	<?php endif; ?>
</p>
<?php endif; ?>

<?php if ($_game->status >= GAME::GAME_ARCHIVED): ?>
<h2 class="info">Игра завершена</h2>
<p>
	<span class="pad-box box"><?php echo link_to('Результаты игры', 'gameControl/report?id='.$_game->id); ?></span>
</p>
<?php endif ?>

<article class="pad-top pad-bottom">
	<?php echo Utils::decodeBB($_game->description) ?>
</article>

<table class="no-border">
	<tbody>
		<tr>
			<th>Организаторы:</th>
			<td><?php echo ($_game->team_id !== null) ? $_game->Team->name : $_game->getTeamBackupName() ?></td>
		</tr>
		<tr>
			<th>Проект:</th>
			<td><?php echo $_game->getRegionSafe()->name ?></td>
		</tr>
		<tr>
			<th>Брифинг:</th>
			<td><?php echo $_game->start_briefing_datetime ?></td>
		</tr>
		<tr>
			<th>Старт игры:</th>
			<td><?php echo $_game->start_datetime ?></td>
		</tr>
		<tr>
			<th>Длительность игры:</th>
			<td><?php echo Timing::intervalToStr($_game->time_per_game*60) ?></td>
		</tr>
		<tr>
			<th>Запланировано заданий:</th>
			<td><?php echo $_game->tasks->count() ?></td>
		</tr>
		<tr>
			<th>Остановка игры:</th>
			<td><?php echo $_game->stop_datetime ?></td>
		</tr>
		<tr>
			<th>Подведение итогов:</th>
			<td><?php echo $_game->finish_briefing_datetime ?></td>
		</tr>
	</tbody>
</table>

<?php if ($_game->teamStates->count() > 0): ?>
<h3>Участвуют</h3>
<table class="no-border">
	<tbody>
		<?php foreach ($_game->teamStates as $teamState): ?>
		<tr>
			<td>
				<?php
					$title = ($teamState->Team->full_name !== '') ? $teamState->Team->full_name : $teamState->Team->name;
					echo link_to($title, 'team/show?id='.$teamState->Team->id, array('target' => '_blank'));
				?>
			</td>
			<td>
				<?php if ($teamState->Team->canBeManaged($sf_user->getSessionWebUser()->getRawValue())): ?>
				<span class="info info-bg pad-box box"><?php echo link_to('Отказаться', 'game/removeTeam?id='.$_game->id.'&teamId='.$teamState->team_id.'&returl='.$retUrlRaw, array('confirm' => 'Вы точно хотите снять команду '.$teamState->Team->name.' с игры '.$_game->name.' ?')) ?></span>
				<?php endif; ?>
				<?php if ($teamState->Team->isPlayer($sf_user->getSessionWebUser()->getRawValue()) && ($_game->status >= Game::GAME_STEADY) && ($_game->status < Game::GAME_ARCHIVED)): ?>
				<span class="pad-box box"><?php echo link_to('Войти&nbsp;в&nbsp;игру', 'play/task?id='.$teamState->id) ?></span>
				<?php endif; ?>
				&nbsp;
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if ($_game->gameCandidates->count() > 0): ?>
<h3>Подали заявки</h3>
<table class="no-border">
	<tbody>
		<?php foreach ($_game->gameCandidates as $gameCandidate): ?>
		<tr>
			<td>
				<?php
					$title = ($gameCandidate->Team->full_name !== '') ? $gameCandidate->Team->full_name : $gameCandidate->Team->name;
					echo link_to($title, 'team/show?id='.$gameCandidate->Team->id, array('target' => '_blank'));
				?>
			</td>
			<td>
				<?php if ($gameCandidate->Team->canBeManaged($sf_user->getSessionWebUser()->getRawValue())): ?>
					<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'game/cancelJoin?id='.$_game->id.'&teamId='.$gameCandidate->team_id.'&returl='.$retUrlRaw) ?></span>
				<?php endif; ?>
				&nbsp;
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>