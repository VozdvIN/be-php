<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Задания')); ?>

<table>
	<thead>
		<tr><th>Команда</th><th>Задание</th><th>Состояние</th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<?php
				$currentTaskState = $teamState->getCurrentTaskState();
				$task = $currentTaskState ? $currentTaskState->Task : false;
			?>
			<td>
				<?php echo link_to($teamState->Team->name, 'team/show?id='.$teamState->Team->id, array('target' => '_blank')); ?>
			</td>
			<?php if ($currentTaskState): ?>
			<td>
				<?php echo link_to($task->name, 'task/params?id='.$task->id, array('target' => '_blank')); ?>
			</td>
			<td>
				<span><?php echo link_to($currentTaskState->describeStatus(), 'play/task?id='.$teamState->id, array('target' => '_blank')); ?></span>
				<?php if ($currentTaskState->Task->manual_start): ?>
				<span class="warn">,&nbsp;вручную</span>
				<?php else: ?>
				<span class="info">,&nbsp;автостарт</span>
				<?php endif; ?>
				<?php if (($currentTaskState->status == TaskState::TASK_GIVEN) && $currentTaskState->Task->isFilled()): ?>
				<span class="warn">,&nbsp;заполнено</span>
				<?php endif ?>
			</td>
			<td>
				<?php
					if ($_isManager)
					{
						include_partial(
							'global/actionsMenu',
							array(
								'items' => array(
									'start' => link_to('Старт', 'taskState/start?id='.$currentTaskState->id, array('method' => 'post', 'confirm' => 'Дать старт заданию '.$task->name.' для команды '.$teamState->Team->name.' ?')),
									'cancel' => link_to('Отменить','teamState/abandonTask?id='.$teamState->id, array('method' => 'post', 'confirm' => 'Отменить выдачу задания '.$task->name.' командe '.$teamState->Team->name.' ?')),
									'accept' => link_to('Прочесть','taskState/forceAccept?id='.$currentTaskState->id, array('method' => 'post', 'confirm' => 'Подтвердить прочтение задания '.$task->name.' командой '.$teamState->Team->name.' ?')),
									'abort' => link_to('Прекратить','teamState/abandonTask?id='.$teamState->id, array('method' => 'post', 'confirm' => 'Прекратить выполнение задания '.$task->name.' командой '.$teamState->Team->name.' ?')),
								),
								'css' => array(
									'start' => 'warn',
									'cancel' => 'info',
									'accept' => 'warn',
									'abort' => 'danger'
								),
								'conditions' => array(
									'start' => $currentTaskState->status == TaskState::TASK_GIVEN
												&& (
													($currentTaskState->Task->isFilled()
													|| $currentTaskState->Task->manual_start)
												),
									'cancel' => $currentTaskState->status == TaskState::TASK_GIVEN
												|| $currentTaskState->status == TaskState::TASK_STARTED,
									'accept' => $currentTaskState->status == TaskState::TASK_STARTED,
									'abort' => $currentTaskState->status == TaskState::TASK_ACCEPTED
								)
							)
						);
					}
				?>
			</td>
			<?php else: ?>
			<td colspan="3">
				<?php if ($teamState->status == TeamState::TEAM_FINISHED): ?>
				<span class="info">Финишировала</span>
				<?php else: ?>
				<span class="warn">Нет задания</span>
				<?php if ($_isManager && ($teamState->status == TeamState::TEAM_WAIT_TASK)): ?>
				<span class="button-danger"><?php echo link_to('Финишировать','teamState/forceFinish?id='.$teamState->id, array('method' => 'post', 'confirm' => 'Отправить команду '.$teamState->Team->name.' на финиш?')) ?></span>
				<?php endif; ?>
				<?php endif; ?>
			</td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>