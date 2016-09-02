<?php
	include_partial(
		'menu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => 'Действия'
		)
	);
?>

<?php
	include_partial(
		'global/actionsMenu',
		array(
			'items' => array(
				'ChangePwd' => link_to('Сменить пароль', 'auth/changePassword', array('method' => 'get')),
				'Edit' => link_to('Редактировать', url_for('webUser/edit?id='.$_webUser->id)),
				'SwitchBlock' => ($_webUser->is_enabled)
					? link_to('Блокировать', 'webUser/disable?id='.$_webUser->id, array('method' => 'post'))
					: link_to('Разблокировать', 'webUser/enable?id='.$_webUser->id, array('method' => 'post')),
				'Delete' => link_to('Удалить', 'webUser/delete?id='.$_webUser->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить пользователя '.$_webUser->login.'?'))
			),
			'css' => array(
				'ChangePwd' => 'warn',
				'Edit' => '',
				'SwitchBlock' => 'warn',
				'Delete' => 'denger',
			),
			'conditions' => array(
				'ChangePwd' => $_isSelf,
				'Edit' => $_isSelf || $_isModerator,
				'SwitchBlock' => $_isModerator,
				'Delete' => ( ! $_isSelf) && $_isModerator
			),
		)
	);
?>