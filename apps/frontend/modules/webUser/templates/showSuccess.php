<?php include_partial('breadcrumbs', array('_webUser' => $_webUser)) ?>
<?php include_partial('menu', array('_activeItem' => 'Анкета', '_webUser' => $_webUser, '_isSelf' => $_isSelf)) ?>

<?php if ( ! $_webUser->is_enabled): ?>
<p class="warn">
	Этот пользователь заблокирован.
</p>
<?php endif ?>

<table class="no-border">
	<thead>
		<tr>
			<td colspan="2">
				<?php
				include_partial(
					'global/actionsMenu',
					array(
						'items' => array(
							'ChangePwd' => link_to('Сменить пароль', 'auth/changePassword', array('method' => 'get')),
							'Edit' => link_to('Редактировать', url_for('webUser/edit?id='.$_webUser->id)),
							'Delete' => link_to('Удалить', 'webUser/delete?id='.$_webUser->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить пользователя '.$_webUser->login.'?')),
							'SwitchBlock' => ($_webUser->is_enabled)
								? link_to('Блокировать', 'webUser/disable?id='.$_webUser->id, array('method' => 'post'))
								: link_to('Разблокировать', 'webUser/enable?id='.$_webUser->id, array('method' => 'post')),
						),
						'css' => array(
							'ChangePwd' => 'warn',
							'Edit' => '',
							'Delete' => 'danger',
							'SwitchBlock' => 'warn'
						),
						'conditions' => array(
							'ChangePwd' => $_isSelf,
							'Edit' => $_isSelf || $_isModerator,
							'Delete' => ( ! $_isSelf) && $_isModerator,
							'SwitchBlock' => $_isModerator
						),
					)
				);
				?>
			</td>
		<tr>
	</thead>
	<tbody>
		<tr><th>Псевдоним:</th><td><?php echo $_webUser->login; ?></td></tr>
		<tr><th>Ф.И.(О.):</th><td><?php echo $_webUser->full_name; ?></td></tr>
		<tr><th>Проект:</th><td><?php echo $_webUser->getRegionSafe()->name; ?></td></tr>
		<?php if ($_isModerator): ?>
		<tr><th>Id:</th><td><?php echo $_webUser->id; ?></td></tr>
		<tr><th>E-Mail:</th><td><?php echo $_webUser->email; ?></td></tr>
		<tr><th>Тэг:</th><td><?php echo $_webUser->tag; ?></td></tr>
		<?php endif; ?>
	</tbody>
</table>
