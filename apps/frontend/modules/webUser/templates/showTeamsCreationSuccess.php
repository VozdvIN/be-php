<?php include_partial('menu', array('_webUser' => $_webUser, '_activeItem' => 'Команды', '_isSelf' => $_isSelf)) ?>

<?php include_partial('teamsMenu', array('_webUser' => $_webUser, '_activeItem' => 'Создание')) ?>

<table class="no-border">
	<?php if ($_teamCreateRequests->count() == 0): ?>
	<thead>
		<tr><td colspan="3">Пользователь не подавал заявок на создание команд.</td></tr>
	</thead>
	<?php else: ?>
	<thead>
		<tr><th>Название</th><th>Сообщение</th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_teamCreateRequests as $teamCreateRequest): ?>
		<tr>
			<td><?php echo $teamCreateRequest->name; ?></td>
			<td><?php echo $teamCreateRequest->description; ?></td>
			<td>
				<?php if ($teamCreateRequest->web_user_id == $_webUser->id): ?>
				<span class="button-info"><?php echo link_to('Отменить', 'teamCreateRequest/delete?id='.$teamCreateRequest->id, array('method' => 'post')); ?></span>
				<?php else: ?>
				&nbsp;
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif; ?>
	<?php if ($_isSelf): ?>
	<tfoot>
		<tr><td colspan="3"><span class="button-info"><?php echo link_to('Создать команду', 'teamCreateRequest/new'); ?></span></td></tr>
	</tfoot>
	<?php endif; ?>
</table>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>