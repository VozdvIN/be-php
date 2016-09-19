<?php include_partial('indexMenu', array('_activeItem' => 'Участники')) ?>

<?php if ($_webUsers->count() == 0): ?>
<p>
	В текущем игровом проекте нет участников.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_webUsers as $webUser): ?>
		<tr>
			<td><?php echo link_to($webUser->login, url_for('webUser/show?id='.$webUser->id)); ?></td>
			<td><?php echo $webUser->full_name; ?>&nbsp;</td>
			<td><?php echo ($webUser->id == $_sessionWebUserId) ? 'Это Вы' : '' ?></td>
			<td><?php echo ( ! $webUser->is_enabled) ? 'Блокирован' : '' ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>