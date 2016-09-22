<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Задания')); ?>

<?php include_partial('tasksMenu', array('_game' => $_game, '_activeItem' => 'Приоритеты')); ?>

<table class="no-border">
	<thead>
		<tr><th rowspan="2">Название</th><th colspan="4">Приоритеты</th></tr>
		<tr><th>Свободно</th><th>Выдано</th><th>Заполнено</th><th>Командный</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_tasks as $task): ?>
		<tr>
			<td><span <?php if ($task->locked): ?> class="danger"<?php endif; ?>><?php echo link_to($task->name, 'task/params?id='.$task->id) ?></span></td>
			<td style="text-align: center;"><?php echo decorate_number($task->priority_free); ?></td>
			<td style="text-align: center;"><?php echo decorate_number($task->priority_busy); ?></td>
			<td style="text-align: center;"><?php echo decorate_number($task->priority_filled); ?></td>
			<td style="text-align: center;"><?php echo decorate_number($task->priority_per_team); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr><td colspan="11"><span class="info">Примечание:</span> <span class="danger">цветом</span> выделены блокированные задания.</td></tr>
	</tfoot>
</table>