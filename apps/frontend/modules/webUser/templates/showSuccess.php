<?php
$retUrlRaw = Utils::encodeSafeUrl('webUser/show?id='.$_webUser->id);

render_breadcombs(array(
    link_to('Участники', 'webUser/index'),
    $_webUser->login
));
?>

<h2>Анкета &quot;<?php echo $_webUser->login ?>&quot;</h2>

<?php if ($_isSelf): ?>
<p class="info info-bg">Это Ваша анкета.</p>
<?php endif ?>

<?php if ( ! $_webUser->is_enabled): ?>
<p class="warn warn-bg">Этот пользователь заблокирован.</p>
<?php endif ?>

<p class="pad-top">
<?php if ($_isSelf): ?>
	<span class="warn warn-bg pad-box box"><?php echo link_to('Сменить пароль', 'auth/changePassword', array('method' => 'get')); ?></span>
<?php endif; ?>
<p>

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
	
	<tfoot>
		<tr>
			<td colspan="2">
				<?php if ($_isSelf || $_isModerator): ?>
					<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', url_for('webUser/edit?id='.$_webUser->id)); ?></span>
				<?php endif; ?>
				<?php if ($_isModerator && ( ! $_isSelf)): ?>
					<span class="danger danger-bg pad-box box"><?php echo link_to('Удалить', 'webUser/delete?id='.$_webUser->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить пользователя '.$_webUser->login.'?')); ?></span>
				<?php endif; ?>
				<?php if ($_isModerator): ?>
					<span class="warn warn-bg pad-box box">
						<?php
						echo ($_webUser->is_enabled)
							? link_to('Блокировать', 'webUser/disable?id='.$_webUser->id.'&returl='.$retUrlRaw, array('method' => 'post'))
							: link_to('Разблокировать', 'webUser/enable?id='.$_webUser->id.'&returl='.$retUrlRaw, array('method' => 'post'))
						?>
					</span>
				<?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>

<h3>Разрешения и запреты</h3>
<table class="no-border">
	<?php if ($_isPermissionModerator): ?>
	<thead>
		<tr><td><span class="info info-bg pad-box box"><?php echo link_to('Добавить', 'grantedPermission/new?webUserId='.$_webUser->id); ?></span></td></tr>
	</thead>
	<?php endif; ?>
	
	<?php if ($_webUser->grantedPermissions->count() > 0): ?>
	<tbody>
		<?php foreach ($_webUser->grantedPermissions as $grantedPermission): ?>
		<tr>
			<?php if ($_isPermissionModerator): ?>
			<td>
				<span class="warn warn-bg pad-box box">
				<?php
				echo $grantedPermission->deny
					? link_to('Снять', 'grantedPermission/delete?id='.$grantedPermission->id.'&returl='.$retUrlRaw, array('method' => 'delete', 'confirm' => 'Снять с пользователя '.$_webUser->login.' запрет '.$grantedPermission->Permission->description.'?'))
					: link_to('Отозвать', 'grantedPermission/delete?id='.$grantedPermission->id.'&returl='.$retUrlRaw, array('method' => 'delete', 'confirm' => 'Отозвать у пользователя '.$_webUser->login.' право '.$grantedPermission->Permission->description.'?'));
				?>
				</span>
			</td>
			<?php endif; ?>			
			<td>
				<?php
					echo ($grantedPermission->deny) ? 'Запрещено' : 'Может';
					echo ' '.$grantedPermission->Permission->description;
					echo ($grantedPermission->filter_id == 0) ? '' : ' с номером #'.$grantedPermission->filter_id;
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif; ?>
</table>
