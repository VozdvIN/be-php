<?php include_partial('breadcrumbs') ?>

<?php include_partial('menu', array(
	'_activeItem' => 'Команды',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<?php include_partial('menuTeams', array('_activeItem' => 'Заявки')) ?>

<?php if ($_teamCreateRequests->count() == 0): ?>
<p>
	Нет команд ни в одном из игровых проектов.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<tr><th>Заявил</th><th>Название</th><th>Полностью</th><th>Проект</th><th>Сообщение</th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_teamCreateRequests as $teamCreateRequest): ?>
		<tr>
			<td><?php echo link_to($teamCreateRequest->WebUser->login, url_for('webUser/show?id='.$teamCreateRequest->WebUser->id), array('target' => '_blank')); ?></td>
			<td><?php echo $teamCreateRequest->name ?></td>
			<td><?php echo $teamCreateRequest->full_name ?></td>
			<td><?php echo $teamCreateRequest->WebUser->getRegionSafe()->name ?></td>
			<td><?php echo $teamCreateRequest->description ?></td>
			<td>
				<?php
				include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'accept' => link_to('Принять', 'moderation/teamsCreateAccept?id='.$teamCreateRequest->id, array('method' => 'post')),
								'decline' => link_to('Отклонить', 'moderation/teamsCreateDecline?id='.$teamCreateRequest->id, array('method' => 'post'))
							),
							'css' => array(
								'accept' => 'info',
								'decline' => 'warn'
							),
							'conditions' => array()
						)
					);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>