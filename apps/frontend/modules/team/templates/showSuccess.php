<?php
	$retUrlRaw = Utils::encodeSafeUrl(url_for('team/show?id='.$_team->id));
?>

<h2>Команда &quot;<?php echo $_team->name ?>&quot;</h2>

<table class="no-border">
	<tbody>
		<tr><th>Название:</th><td><?php echo $_team->name; ?></td></tr>
		<tr><th>Полное название:</th><td><?php echo $_team->full_name; ?></td></tr>
		<tr><th>Проект:</th><td><?php echo $_team->getRegionSafe()->name; ?></td></tr>
		<?php if ($_isModerator): ?>
		<tr><th>Id:</th><td><?php echo $_team->id; ?></td></tr>
		<?php endif; ?>
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="2">
				<?php if ($_sessionIsLeader || $_sessionIsModerator): ?>
					<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', url_for('team/edit?id='.$_team->id)); ?></span>
				<?php endif; ?>
				<?php if ($_sessionIsModerator): ?>
					<span class="danger danger-bg pad-box box"><?php echo link_to('Удалить команду', 'team/delete?id='.$_team->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить команду '.$_team->name.'?')); ?></span>
				<?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>

<h3>Игроки команды</h3>

<table class="no-border">
	<?php if ($_sessionIsLeader || $_sessionIsModerator): ?>
	<thead>
		<tr><td colspan="3"><span class="info info-bg pad-box box"><?php echo link_to('Вербовать нового', 'team/registerPlayer'.'?id='.$_team->id.'&returl='.$retUrlRaw); ?></span></td></tr>
	</thead>
	<?php endif; ?>

	<?php if ($_team->teamPlayers->count() > 0): ?>
	<tbody>
		<?php foreach ($_team->teamPlayers as $teamPlayer): ?>
		<tr>
			<?php
				$webUser = $teamPlayer->WebUser->getRawValue();
				$isLeader = $teamPlayer->is_leader;
			?>
			<td>
				<?php echo link_to($webUser->login, 'webUser/show?id='.$webUser->id, array('target' => 'new')); ?>
			</td>
			<td>
				<?php echo ($isLeader) ? 'Капитан' : 'Рядовой'; ?>
			</td>
			<td>
				<?php if ($_sessionIsLeader || $_sessionIsModerator): ?>
					<?php if ($isLeader): ?>
					<span class="info info-bg pad-box box"><?php echo link_to('Разжаловать', 'team/setPlayer?id='.$_team->id.'&userId='.$webUser->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отобрать у игрока '.$webUser->login.' полномочия капитана команды '.$_team->name.'?')); ?></span>
					<?php else: ?>
					<span class="warn warn-bg pad-box box"><?php echo link_to('Повысить', 'team/setLeader?id='.$_team->id.'&userId='.$webUser->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Назначить игрока '.$webUser->login.' капитаном команды '.$_team->name.'?')); ?></span>
					<?php endif; ?>

					<?php $retireCls = $isLeader ? 'danger' : 'warn' ?>
					<span class="<?php echo $retireCls; ?> <?php echo $retireCls; ?>-bg pad-box box">
						<?php echo link_to('Демобилизовать', 'team/unregister?id='.$_team->id.'&userId='.$webUser->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отчислить игрока '.$webUser->login.' из команды '.$_team->name.'?')); ?>
					</span>
				<?php endif ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php else: ?>
	<p class="warn">
		В команде нет игроков. Все действия от лица капитана и игроков команды должен выполнять модератор.
	</p>
	<?php endif; ?>
</table>

<h3>Заявки в состав</h3>

<table class="no-border">
	<?php if ($_sessionIsLeader || $_sessionIsModerator): ?>
	<thead>
		<tr><td colspan="3"><span class="info info-bg pad-box box"><?php echo link_to('Подать свою', 'team/postJoin'.'?id='.$_team->id.'&userId='.$_sessionWebUserId.'&returl='.$retUrlRaw, array('method' => 'post')); ?></span></td></tr>
	</thead>
	<?php endif; ?>

	<tbody>
		<?php if ($_teamCandidates->count() > 0): ?>
		<?php	foreach ($_teamCandidates as $teamCandidate): ?>
		<?php	$candidateUser = $teamCandidate->WebUser; ?>
		<tr>
			<td><?php echo link_to($candidateUser->login, 'webUser/show?id='.$candidateUser->id, array('target' => 'new')); ?></td>
			<td>
				<?php if ($_sessionIsLeader || $_sessionIsModerator): ?>
				<span class="warn warn-bg pad-box box"><?php echo link_to('Вербовать', 'team/setPlayer?id='.$_team->id.'&userId='.$webUser->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Утвердить '.$webUser->login.' в состав команды '.$_team->name.'?')); ?></span>
				<?php endif; ?>
				
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'team/cancelJoin?id='.$_team->id.'&userId='.$webUser->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отменить заявку '.$webUser->login.' в состав команды '.$_team->name.'?')); ?></span>				
			</td>
		</tr>
		<?php	endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="3">
				<p>
					Активных заявок нет.
				</p>
			</td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>

<h3>Участие в играх</h3>

<?php if ($_teamStates->count() == 0): ?>
<p>
	Команда пока не участвовала ни в одной из игр.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<td><?php echo link_to($teamState->Game->name, 'game/show?id='.$teamState->game_id, array('target' => 'new')); ?></td>
			<td>
				<?php
				if ($teamState->Game->status == Game::GAME_STEADY
					|| $teamState->Game->status == Game::GAME_ACTIVE
					|| $teamState->Game->status == Game::GAME_FINISHED)
				{
					echo link_to('К&nbsp;заданию', 'teamState/task?id='.$teamState->id, array('target' => 'new'));
				}
				elseif ($teamState->Game->status == Game::GAME_ARCHIVED)
				{
					echo link_to('Итоги', 'gameControl/report?id='.$teamState->game_id, array('target' => 'new'));
				}
				?>
			</td>
		</tr>
		<?php endforeach; ?>;
	</tbody>
</table>
<?php endif; ?>

<h3>Организация игр</h3>
<?php if ($_games->count() == 0): ?>
<p>
	Команда пока не организовывала игр.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/show?id='.$game->id, array('target' => 'new')); ?></td>
			<td>
				<?php
				if ($game->status == Game::GAME_STEADY
					|| $game->status == Game::GAME_ACTIVE
					|| $game->status == Game::GAME_FINISHED)
				{
					echo link_to('Управление', 'gameControl/pilot?id='.$game->id, array('target' => 'new'));
				}
				elseif ($game->status == Game::GAME_ARCHIVED)
				{
					echo link_to('Итоги', 'gameControl/report?id='.$game->id, array('target' => 'new'));
				}
				?>
			</td>
		</tr>
		<?php endforeach; ?>;
	</tbody>
</table>
<?php endif; ?>