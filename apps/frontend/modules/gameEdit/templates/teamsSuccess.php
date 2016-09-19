<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Регистрация'
		)
	);
	
	$retUrlRaw = Utils::encodeSafeUrl(url_for('game/teams?id='.$_game->id));
?>

<?php if ($_teamStates->count() <= 0): ?>
<p>
	Нет участвующих команд.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<?php if ($_isModerator): ?>
		<tr>
			<td colspan="4">
				<span class="button-info"><?php echo link_to('Зарегистрировать команду', 'game/addTeamManual?id='.$_game->id.'&returl='.$retUrlRaw, array('method' => 'post')); ?></span>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<th>Команда</th>
			<th>Стартует</th>
			<th>Автоматизация</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($_teamStates as $teamState): ?>
		<tr>
			<td><?php echo link_to($teamState->Team->name, 'team/show?id='.$teamState->team_id, array ('target' => '_blank')); ?></td>
			<td><?php echo ($teamState->start_delay == 0) ? 'сразу' : 'через '.Timing::intervalToStr($teamState->start_delay*60) ?></td>
			<td><?php echo ($teamState->ai_enabled == 0) ? 'отключена' : 'да' ?></td>
			<td>
				<span class="button-info"><?php echo link_to('Настройки', 'teamState/edit?id='.$teamState->id) ?></span>
				<?php if ($_canManage || $_isModerator): ?>
					<span class="button-warn"><?php echo link_to('Снять с игры', 'game/removeTeam?id='.$_game->id.'&teamId='.$teamState->team_id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Вы точно хотите снять команду '.$teamState->Team->name.' с игры '.$_game->name.'?')) ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if ($_gameCandidates->count() > 0): ?>
<h3>Заявки на участие</h3>
<table class="no-border">
	<tbody>
		<?php foreach($_gameCandidates as $candidate): ?>
		<tr>
			<td><?php echo link_to($candidate->Team->name, 'team/show?id='.$candidate->team_id, array('target' => '_blank')) ?></td>
			<td>
				<?php if ($_canManage || $_isModerator): ?>
					<span class="button-warn">
						<?php echo link_to('Отклонить', 'game/cancelJoin?id='.$_game->id.'&teamId='.$candidate->team_id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отклонить заявку команды '.$candidate->Team->name.' на участие в игре '.$_game->name.'?')) ?>
					</span>
					<span class="button-info">
						<?php echo link_to('Утвердить', 'game/addTeam?id='.$_game->id.'&teamId='.$candidate->team_id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Принять команду '.$candidate->Team->name.' к участию в игре '.$_game->name.'?')) ?>
					</span>					
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>


