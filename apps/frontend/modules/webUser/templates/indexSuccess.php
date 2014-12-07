<h2>Участники</h2>

<table class="no-border">
	<tbody>
		<?php foreach ($_webUsers as $webUser): ?>
		<tr>
			<td><?php echo link_to($webUser->login, url_for('webUser/show?id='.$webUser->id)); ?></td>
			<td><?php echo $webUser->full_name; ?>&nbsp;</td>
			<td>
				<?php echo ($webUser->id == $_sessionWebUserId) ? 'Это Вы' : '' ?>
				<?php echo (!$webUser->is_enabled) ? 'Блокирован' : '' ?>
				&nbsp;
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>