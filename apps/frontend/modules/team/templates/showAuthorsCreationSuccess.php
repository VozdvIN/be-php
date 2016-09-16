<?php include_partial('menu', array('_team' => $_team, '_activeItem' => 'Организация')) ?>

<?php include_partial('crewMenu', array('_team' => $_team, '_activeItem' => 'Заявки')) ?>

<table class="no-border wide">
	<?php if ($_gameCreateRequests->count() == 0): ?>
	<thead>
		<tr>
			<td colspan="3">Команда не подавала заявок на создание игр.</td>
		</tr>
	</thead>
	<?php else: ?>
	<thead>
		<tr>
			<th>Название</th>
			<th>Сообщение</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_gameCreateRequests as $gameCreateRequest): ?>
		<tr>
			<td><?php echo $gameCreateRequest->name; ?></td>
			<td><?php echo $gameCreateRequest->description; ?></td>
			<td>
				<?php if ($_sessionCanManage): ?>
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'gameCreateRequest/delete?id='.$gameCreateRequest->id, array('method' => 'post')); ?></span>
				<?php else: ?>
				&nbsp;
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<?php endif; ?>

	<?php if ($_sessionCanManage): ?>
	<tfoot>
		<tr>
			<td colspan="3">
				<span class="info info-bg pad-box box"><?php echo link_to('Создать игру', 'gameCreateRequest/new?teamId='.$_team->id); ?></span>
			</td>
		</tr>
	</tfoot>
	<?php endif; ?>
</table>