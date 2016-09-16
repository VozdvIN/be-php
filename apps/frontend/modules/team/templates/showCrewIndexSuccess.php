<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Состав')) ?>

<?php include_partial('crewMenu', array('_team' => $_team, '_activeItem' => 'Экипаж')) ?>

<?php if ($_team->teamPlayers->count() == 0): ?>
<p class="warn">
	В команде нет игроков. Все действия от лица капитана и игроков команды должен выполнять модератор.
</p>
<?php else: ?>
<table class="no-border">
	<?php if ($_sessionIsModerator): ?>
	<thead>
		<tr>
			<td colspan="3">
				<span class="button-info"><?php echo link_to('Вербовать', 'team/registerPlayer'.'?id='.$_team->id); ?></span>
			</td>
		</tr>
	</thead>
	<?php endif; ?>
	<tbody>
		<?php foreach ($_team->teamPlayers as $teamPlayer): ?>
		<tr>
			<?php
				$webUser = $teamPlayer->WebUser->getRawValue();
				$isLeader = $teamPlayer->is_leader;
			?>
			<td>
				<?php echo link_to($webUser->login, 'webUser/show?id='.$webUser->id, array('target' => '_blank')); ?>
			</td>
			<td>
				<?php echo ($isLeader) ? 'Капитан' : 'Рядовой'; ?>
			</td>
			<td>
				<?php
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'Retire' => link_to('Уволить', 'team/unregister?id='.$_team->id.'&userId='.$webUser->id, array('method' => 'post', 'confirm' => 'Отчислить игрока '.$webUser->login.' из команды '.$_team->name.'?')),
								'ToPrivate' => link_to('Разжаловать', 'team/setPlayer?id='.$_team->id.'&userId='.$webUser->id, array('method' => 'post', 'confirm' => 'Отобрать у игрока '.$webUser->login.' полномочия капитана команды '.$_team->name.'?')),
								'ToLeader' => link_to('Повысить', 'team/setLeader?id='.$_team->id.'&userId='.$webUser->id, array('method' => 'post', 'confirm' => 'Назначить игрока '.$webUser->login.' капитаном команды '.$_team->name.'?'))
							),
							'css' => array(
								'Retire' => 'warn',
								'ToPrivate' => 'info',
								'ToLeader' => 'warn'
							),
							'conditions' => array(
								'Retire' => $_sessionCanManage,
								'ToPrivate' => $_sessionCanManage && $isLeader,
								'ToLeader' => $_sessionCanManage && ( ! $isLeader)
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