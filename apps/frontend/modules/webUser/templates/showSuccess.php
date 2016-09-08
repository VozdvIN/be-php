<?php
	$retUrlRaw = Utils::encodeSafeUrl('webUser/show?id='.$_webUser->id);
?>

<?php
	include_partial(
		'menu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => $_webUser
		)
	)
?>

<?php if ( ! $_webUser->is_enabled): ?>
<p class="warn warn-bg">
	Этот пользователь заблокирован.
</p>
<?php endif ?>

<?php if ($_isSelf): ?>
<p class="info">
	Это ваша анкета.
</p>
<?php endif ?>

<table class="no-border">
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