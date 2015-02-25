<?php
	include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Параметры'));
	$retUrlRaw = Utils::encodeSafeUrl(url_for('game/tasks?id='.$_game->id));
?>

<table class="no-border">
	<tbody>
		<tr>
			<td colspan="2"><h5>Основные</h5></td>
		</tr>
		<tr>
			<th>Внутреннее название:</th>
			<td><?php echo $_task->name ?></td>
		</tr>
		<tr>
			<th>Открытое название:</th>
			<td><?php echo $_task->public_name ?></td>
		</tr>
		<tr>
			<th>Длительность:</th>
			<td><?php echo Timing::intervalToStr($_task->time_per_task_local*60) ?></td>
		</tr>
		<tr>
			<th>Ошибок не более:</th>
			<td><?php echo $_task->try_count_local ?></td>
		</tr>
		<tr>
			<th>Ответов необходимо:</th>
			<td><?php echo ($_task->min_answers_to_success > 0) ? $_task->min_answers_to_success : 'все' ?></td>
		</tr>
		<tr>
			<td colspan="2"><h5>Управление</h5></td>
		</tr>
		<tr>
			<th>Команд на задании:</th>
			<td><?php echo ($_task->max_teams > 0) ? 'не&nbsp;более&nbsp;'.$_task->max_teams : 'без&nbsp;ограничений' ?></td>
		</tr>
		<tr>
			<th>Ручной старт:</th>
			<td><?php echo $_task->manual_start ? decorate_span('warn', 'Да') : 'Нет' ?></td>
		</tr>
		<tr>
			<th>Заблокировано:</th>
			<td><?php echo $_task->locked ? decorate_span('danger', 'Да') : 'Нет' ?></td>
		</tr>
		<tr>
			<td colspan="2"><h5>Приоритеты</h5></td>
		</tr>
		<tr>
			<th>Когда свободно:</th>
			<td><?php echo decorate_number($_task->priority_free) ?></td>
		</tr>
		<tr>
			<th>Когда выдано:</th>
			<td><?php echo decorate_number($_task->priority_busy) ?></td>
		</tr>
		<tr>
			<th>Когда заполнено:</th>
			<td><?php echo decorate_number($_task->priority_filled) ?></td>
		</tr>
		<tr>
			<th>На каждую команду:</th>
			<td><?php echo decorate_number($_task->priority_per_team) ?></td>
		</tr>
	</tbody>
	<?php if ($_isManager || $_isModerator): ?>
	<tfoot>
		<tr>
			<td colspan="2">
				<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'task/edit?id='.$_task->id) ?></span>
				<span class="danger danger-bg pad-box box"><?php echo link_to('Удалить задание', 'task/delete?id='.$_task->id.'&returl='.$retUrlRaw, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить задание '.$_task->name.'?')) ?></span>
			</td>
		</tr>		
	</tfoot>
	<?php endif; ?>
</table>