<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Команды')); ?>

<?php if ($_teamStates->count() <= 0): ?>
<p>
	Нет участвующих команд.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<?php if ($_isModerator): ?>
		<tr><td colspan="4"><span class="button-info"><?php echo link_to('Зарегистрировать команду', 'game/addTeamManual?id='.$_game->id, array('method' => 'post')); ?></span></td></tr>
		<?php endif; ?>
		<tr><th>Команда</th><th>Стартует</th><th>ИИ</th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php foreach($_teamStates as $teamState): ?>
		<tr>
			<td><?php echo link_to($teamState->Team->name, 'team/show?id='.$teamState->team_id, array ('target' => '_blank')); ?></td>
			<td><?php echo ($teamState->start_delay == 0) ? 'сразу' : 'через '.Timing::intervalToStr($teamState->start_delay*60) ?></td>
			<td><?php echo ($teamState->ai_enabled == 0) ? 'отключен' : 'активен' ?></td>
			<td>
				<?php
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'settings' => link_to('Настройки', 'teamState/edit?id='.$teamState->id),
								'remove' => link_to(
									'Снять&nbsp;с&nbsp;игры',
									'game/removeTeam?id='.$_game->id.'&teamId='.$teamState->team_id,
									array(
										'method' => 'post',
										'confirm' => 'Вы точно хотите снять команду '.$teamState->Team->name.' с игры '.$_game->name.'?'
									)
								),
							),
							'css' => array(
								'settings' => '',
								'remove' => $_game->status >= Game::GAME_STEADY ? 'danger' : 'warn'
							),
							'conditions' => array(
								'settings' => true,
								'remove' => $_canManage || $_isModerator
							)
						)
					);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>
