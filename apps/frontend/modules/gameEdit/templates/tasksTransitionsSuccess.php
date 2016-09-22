<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Задания')); ?>

<?php include_partial('tasksMenu', array('_game' => $_game, '_activeItem' => 'Фильтры')); ?>

<table class="no-border">
	<thead>
		<tr><th rowspan="2">С задания</th><th colspan="<?php echo $_tasks->count(); ?>">На задание</th></tr><tr>
		<?php foreach ($_tasks as $task): ?>
			<td><?php echo $task->name ?></td>
		<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_tasks as $task): ?>
		<tr>
			<td><?php echo link_to($task->name, 'task/transitions?id='.$task->id) ?></td>
			<?php for($i = 0; $i < $_tasks->count(); $i++): //Если поставить foreach, то внешний цикл почему-то только один раз выполняется.?>
				<?php $transition = $task->findTransitionToTask($_tasks[$i]->getRawValue()); ?>
				<td style="text-align: center;">
					<?php if ($transition === false): ?>.
					<?php else: ?>
					<?php     if ($transition->allow_on_success && $transition->allow_on_fail): ?>
					<span>Всегда</span>
					<?php     elseif ($transition->allow_on_success): ?>
					<span class="info">При&nbsp;успехе</span>
					<?php     elseif ($transition->allow_on_fail): ?>
					<span class="info">При&nbsp;провале</span>
					<?php     endif; ?>
					<?php     if($transition->manual_selection): ?>
					<br /><span>Вручную</span>
					<?php     endif; ?>
					<?php endif; ?>
				</td>
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>