<?php
	include_partial('menu', array('_game' => $_game, '_activeItem' => 'Команды', '_editable' => $_canManage));
	$currentUser = $sf_user->getSessionWebUser()->getRawValue();
?>

<?php if (($_teamStates->count() == 0) && ($_gameCandidates->count() == 0)): ?>
<p>
	Нет участвующих команд.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<td><?php echo link_to($teamState->Team->getNormalName(), 'team/show?id='.$teamState->Team->id); ?></td>
			<td>Участвует</td>
			<td>
				<?php
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'Play' => link_to('Войти&nbsp;в&nbsp;игру', 'play/task?id='.$teamState->id),
								'Leave' => link_to(
									'Отказаться',
									'game/removeTeam?id='.$teamState->game_id.'&teamId='.$teamState->team_id,
									array('confirm' => 'Вы точно хотите снять команду '.$teamState->Team->name.' с игры '.$_game->name.' ?')
								)
							),
							'css' => array(
								'Play' => 'info',
								'Leave' => $_game->status >= Game::GAME_STEADY ? 'danger' : 'warn'
							),
							'conditions' => array(
								'Play' => $_game->isActive() && ($_canManage || $teamState->Team->isPlayer($currentUser)),
								'Leave' => $teamState->Team->canBeManaged($currentUser)
							)
						)
					);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
		<?php foreach ($_gameCandidates as $gameCandidate): ?>
		<tr>
			<td><?php echo link_to($gameCandidate->Team->getNormalName(), 'team/show?id='.$gameCandidate->Team->id); ?></td>
			<td>Подала заявку</td>
			<td>
				<?php
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array('Cancel' => link_to('Отменить', 'game/cancelJoin?id='.$_game->id.'&teamId='.$gameCandidate->team_id)),
							'css' => array('Cancel' => 'info'),
							'conditions' => array('Cancel' => $gameCandidate->Team->canBeManaged($currentUser))
						)
					);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>