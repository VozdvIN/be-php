<?php include_partial('breadcrumbs', array('_team' => $_team)) ?>
<?php include_partial('menu', array('_activeItem' => 'Организация', '_team' => $_team, )) ?>
<?php include_partial('authorsMenu', array('_activeItem' => 'Заявки', '_team' => $_team)) ?>

<table class="no-border">
	<thead>
		<?php if ($_sessionCanManage): ?>
		<tr><td colspan="3"><span class="button-info"><?php echo link_to('Создать игру', 'gameCreateRequest/new?teamId='.$_team->id); ?></span></td></tr>
		<?php endif; ?>
		<?php if ($_gameCreateRequests->count() == 0): ?>
		<tr><td colspan="3">Команда не подавала заявок на создание игр.</td></tr>
		<?php else: ?>
		<tr><th>Название</th><th>Сообщение</th><th>&nbsp;</th></tr>
		<?php endif; ?>
	</thead>
	<tbody>
		<?php foreach ($_gameCreateRequests as $gameCreateRequest): ?>
		<tr>
			<td><?php echo $gameCreateRequest->name; ?></td>
			<td><?php echo $gameCreateRequest->description; ?></td>
			<td>
				<?php if ($_sessionCanManage): ?>
				<span class="button-info"><?php echo link_to('Отменить', 'gameCreateRequest/delete?id='.$gameCreateRequest->id, array('method' => 'post')); ?></span>
				<?php else: ?>
				&nbsp;
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>