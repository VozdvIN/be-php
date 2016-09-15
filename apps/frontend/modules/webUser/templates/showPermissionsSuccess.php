<?php include_partial('menu', array('_webUser' => $_webUser, '_activeItem' => 'Права', '_isSelf' => $_isSelf)) ?>

<table class="no-border">
	<?php if ($_webUser->grantedPermissions->count() == 0): ?>
	<tbody>
		<tr>
			<td>У пользователя нет особых прав или запретов.</td>
		</tr>
	</tbody>
	<?php else: ?>
	<tbody>
		<?php foreach ($_webUser->grantedPermissions as $grantedPermission): ?>
		<tr>
			<td>
				<?php
					echo ($grantedPermission->deny) ? 'Запрещено' : 'Может';
					echo ' '.$grantedPermission->Permission->description;
					echo ($grantedPermission->filter_id == 0) ? '' : ' с номером #'.$grantedPermission->filter_id;
				?>
			</td>
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
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif; ?>

	<?php if ($_isPermissionModerator): ?>
	<tfoot>
		<tr>
			<td colspan="2"><span class="info info-bg pad-box box"><?php echo link_to('Добавить', 'grantedPermission/new?webUserId='.$_webUser->id); ?></span></td>
		</tr>
	</tfoot>
	<?php endif; ?>
</table>