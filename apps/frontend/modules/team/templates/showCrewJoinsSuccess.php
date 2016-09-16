<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Состав')) ?>

<?php include_partial('crewMenu', array('_team' => $_team, '_activeItem' => 'Заявки')) ?>

<table class="no-border">
	<tbody>
		<?php if ($_teamCandidates->count() == 0): ?>
		<tr>
			<td colspan="2">
				Активных заявок нет.
			</td>
		</tr>
		<?php else: ?>
		<?php     foreach ($_teamCandidates as $teamCandidate): ?>
		<?php     $candidateUser = $teamCandidate->WebUser; ?>
		<tr>
			<td><?php echo link_to($candidateUser->login, 'webUser/show?id='.$candidateUser->id, array('target' => '_blank')); ?></td>
			<td>
				<?php
				include_partial(
					'global/actionsMenu',
					array(
						'items' => array(
							'Hire' => link_to('Вербовать', 'team/setPlayer?id='.$_team->id.'&userId='.$candidateUser->id, array('method' => 'post', 'confirm' => 'Утвердить '.$candidateUser->login.' в состав команды '.$_team->name.'?')),
							'Cancel' => link_to('Отменить', 'team/cancelJoin?id='.$_team->id.'&userId='.$candidateUser->id, array('method' => 'post', 'confirm' => 'Отменить заявку '.$candidateUser->login.' в состав команды '.$_team->name.'?'))
						),
						'css' => array(
							'Hire' => 'warn',
							'Cancel' => 'info'
						),
						'conditions' => array(
							'Hire' => $_sessionCanManage,
							'Cancel' => $_sessionCanManage || ($_sessionWebUser->id == $candidateUser->id)
						),
					)
				)
				?>
			</td>
		</tr>
		<?php     endforeach; ?>
		<?php endif; ?>
	</tbody>
	<?php if ($_canPostJoin): ?>
	<tfoot>
		<tr>
			<td colspan="3">
				<span class="button-info"><?php echo link_to('Подать свою', 'team/postJoin'.'?id='.$_team->id.'&userId='.$_sessionWebUser->id, array('method' => 'post')); ?></span>
			</td>
		</tr>
	</tfoot>
	<?php endif; ?>
</table>