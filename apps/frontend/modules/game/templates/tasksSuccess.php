<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Задания',
			'_isModerator' => $_isModerator
		)
	);
	
	$retUrlRaw = Utils::encodeSafeUrl(url_for('game/teams?id='.$_game->id));
?>

<table class="no-border">
	<thead>
		<?php if ($_canManage || $_isModerator): ?>
		<tr>
			<td colspan="11">
				<span class="info info-bg pad-box box"><?php echo link_to('Создать задание', 'task/new?gameId='.$_game->id); ?></span>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<th rowspan="2">Название</th>
			<th rowspan="2">Длительность</th>
			<th colspan="2">Ответов</th>
			<th rowspan="2">Ошибок</th>
			<th rowspan="2">Пауза</th>
			<th rowspan="2">Команд</th>
			<th colspan="4">Приоритеты</th>
		</tr>
		<tr>
			<th>Всего</th>
			<th>Зачетных</th>
			<th>Свободно</th>
			<th>Выдано</th>
			<th>Заполнено</th>
			<th>Командный</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_tasks as $task): ?>
		<tr>
			<td>
				<?php if ($task->locked): ?>
				<span class="danger"><?php echo link_to($task->name, 'task/params?id='.$task->id) ?></span>
				<?php else: ?>
				<?php echo link_to($task->name, 'task/params?id='.$task->id) ?>
				<?php endif; ?>
			</td>
			<td><?php echo Timing::intervalToStr($task->time_per_task_local*60) ?></td>
			<td><?php echo $task->answers->count() ?></td>
			<td><?php echo ($task->min_answers_to_success > 0) ? $task->min_answers_to_success : 'все' ?></td>
			<td><?php echo '&lt;=&nbsp;'.$task->try_count_local ?></td>
			<td><?php echo $task->manual_start ? 'Да' : '.' ?></td>
			<td><?php echo ($task->max_teams > 0) ? '&lt;=&nbsp;'.$task->max_teams : 'все' ?></td>
			<td><?php echo decorate_number($task->priority_free); ?></td>
			<td><?php echo decorate_number($task->priority_busy); ?></td>
			<td><?php echo decorate_number($task->priority_filled); ?></td>
			<td><?php echo decorate_number($task->priority_per_team); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="11">
				Примечание: <span class="danger">цветом</span> выделены блокированные задания.
			</td>
		</tr>
	</tfoot>
</table>

<h4>Приоритеты переходов</h4>

<table class="no-border">
	<thead>
		<tr>
			<th rowspan="2">С задания</th>
			<th colspan="<?php echo $_tasks->count(); ?>">На задание</th>
		</tr>
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
				<td><?php echo (($priority === false) || ($priority == 0)) ? '.' : decorate_number($priority) ?></td>			
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<h4>Фильтры переходов</h4>

<table class="no-border">
	<thead>
		<tr>
			<th rowspan="2">С задания</th>
			<th colspan="<?php echo $_tasks->count(); ?>">На задание</th>
		</tr>
		<tr>
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
				<td>
					<?php if ($transition === false): ?>
						.
					<?php elseif ($transition->allow_on_success && $transition->allow_on_fail): ?>
						<?php echo 'Всегда'.($transition->manual_selection ? ',<br>вручную' : '') ?>
					<?php elseif ($transition->allow_on_success): ?>
						<span class="info"><?php echo 'При&nbsp;успехе' ?></span><?php echo ($transition->manual_selection ? ',<br>вручную' : '') ?>
					<?php elseif ($transition->allow_on_fail): ?>
						<span class="warn"><?php echo 'При&nbsp;неудаче' ?></span><?php echo ($transition->manual_selection ? ',<br>вручную' : '') ?>
					<?php endif; ?>
				</td>			
			<?php endfor; ?>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>