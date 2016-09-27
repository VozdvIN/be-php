<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Задания')); ?>

<?php include_partial('tasksMenu', array('_game' => $_game, '_activeItem' => 'Список')); ?>

<table class="no-border">
	<thead>
		<tr><th rowspan="2">Название</th><th rowspan="2">Времени</th><th colspan="2">Ответов</th><th rowspan="2">Ошибок</th><th rowspan="2">Пауза</th><th rowspan="2">Команд</th></tr>
		<tr><th>Всего</th><th>Min</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_tasks as $task): ?>
		<tr>
			<td><span <?php if ($task->locked): ?> class="danger"<?php endif; ?>><?php echo link_to($task->name, 'task/params?id='.$task->id) ?></span></td>
			<td style="text-align: center;"><?php echo Timing::intervalToStr($task->time_per_task_local*60) ?></td>
			<td style="text-align: center;"><?php echo $task->answers->count() ?></td>
			<td style="text-align: center;"><?php echo ($task->min_answers_to_success > 0) ? $task->min_answers_to_success : 'все' ?></td>
			<td style="text-align: center;"><?php echo '&lt;=&nbsp;'.$task->try_count_local ?></td>
			<td style="text-align: center;"><?php echo $task->manual_start ? 'Да' : '.' ?></td>
			<td style="text-align: center;"><?php echo ($task->max_teams > 0) ? '&lt;=&nbsp;'.$task->max_teams : 'все' ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr><td colspan="11"><span class="info">Примечание:</span> <span class="danger">цветом</span> выделены блокированные задания.</td></tr>
		<?php if ($_canManage || $_isModerator): ?>
		<tr><td colspan="11"><span class="button-info"><?php echo link_to('Создать задание', 'task/new?gameId='.$_game->id); ?></span></td></tr>
		<?php endif; ?>
	</tfoot>
</table>