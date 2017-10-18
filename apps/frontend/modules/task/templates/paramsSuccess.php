<?php include_partial('taskMenu', array('_task' => $_task, '_activeItem' => $_task->name.' (Редактор)')); ?>

<table class="no-border">
	<thead>
		<tr>
			<td colspan="2">
				<?php
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'edit' => link_to('Редактировать', 'task/edit?id='.$_task->id),
								'delete' => link_to(
									'Удалить',
									'task/delete?id='.$_task->id,
									array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить задание '.$_task->name.'?')
								),
							),
							'css' => array(
								'edit' => '',
								'delete' => 'danger'
							),
							'conditions' => array(
								'edit' => $_isManager || $_isModerator,
								'delete' => $_isManager || $_isModerator
							)
						)
					);
				?>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr><th>Внутреннее название:</th><td><?php echo $_task->name ?></td></tr>
		<tr><th>Открытое название:</th><td><?php echo $_task->public_name ?></td></tr>
		<tr><th>Длительность:</th><td><?php echo Timing::intervalToStr($_task->time_per_task_local*60) ?></td></tr>
		<tr><th>Ошибок не более:</th><td><?php echo $_task->try_count_local ?></td></tr>
		<tr><th>Ответов необходимо:</th><td><?php echo ($_task->min_answers_to_success > 0) ? $_task->min_answers_to_success : 'все' ?></td></tr>
		<tr><td colspan="2"><h5 style="text-align: center">Управление</h5></td></tr>
		<tr><th>Команд на задании:</th><td><?php echo ($_task->max_teams > 0) ? 'не&nbsp;более&nbsp;'.$_task->max_teams : 'без&nbsp;ограничений' ?></td></tr>
		<tr><th>Ручной старт:</th><td><?php echo $_task->manual_start ? decorate_span('warn', 'Да') : 'Нет' ?></td></tr>
		<tr><th>Заблокировано:</th><td><?php echo $_task->locked ? decorate_span('danger', 'Да') : 'Нет' ?></td></tr>
		<tr><td colspan="2"><h5 style="text-align: center">Приоритеты</h5></td></tr>
		<tr><th>Когда свободно:</th><td><?php echo decorate_number($_task->priority_free) ?></td></tr>
		<tr><th>Когда выдано:</th><td><?php echo decorate_number($_task->priority_busy) ?></td></tr>
		<tr><th>Когда заполнено:</th><td><?php echo decorate_number($_task->priority_filled) ?></td></tr>
		<tr><th>На каждую команду:</th><td><?php echo decorate_number($_task->priority_per_team) ?></td></tr>
	</tbody>
</table>