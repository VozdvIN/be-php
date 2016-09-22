<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Задания')); ?>

<?php include_partial('tasksMenu', array('_game' => $_game, '_activeItem' => 'Переходы')); ?>

<table class="no-border">
	<thead>
		<tr><th rowspan="2">С задания</th><th colspan="<?php echo $_tasks->count(); ?>">На задание</th></tr>
		<tr>
		<?php foreach ($_tasks as $task): ?>
			<td><?php echo $task->name ?></td>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_tasks as $task): ?>
		<tr>
			<td><?php echo link_to($task->name, 'task/constraints?id='.$task->id) ?></td>
			<?php for($i = 0; $i < $_tasks->count(); $i++): //Если поставить foreach, то внешний цикл почему-то только один раз выполняется.?>
				<?php $priority = $task->getPriorityJump($_tasks[$i]->getRawValue()); ?>
				<td style="text-align: center;"><?php echo (($priority === false) || ($priority == 0)) ? '.' : decorate_number($priority) ?></td>
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>