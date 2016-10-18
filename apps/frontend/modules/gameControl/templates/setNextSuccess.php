<h2>Назначение следующего задания команде <?php echo $_teamState->Team->name ?></h2>

<?php if ($_teamState->getCurrentTaskState()): ?>
<p class="warn">
	Для обоснованного выбора следующего задания рекомендуется дождаться завершения командой текущего задания, так как указанная ниже информация о заданиях может существенно измениться.
</p>
<?php endif ?>

<p>
	<?php if ($_teamState->ai_enabled): ?>
	<span class="button-info"><?php echo link_to('Использовать автовыбор', 'gameControl/setNext?teamState='.$_teamState->id.'&taskId=0', array ('method' => 'post')); ?></span>
	<?php else: ?>
		<?php if ($_teamState->task_id > 0): ?>
	<span class="button-warn"><?php echo link_to('Отменить выбор назначенного задания', 'gameControl/setNext?teamState='.$_teamState->id.'&taskId=0', array ('method' => 'post')); ?></span>
		<?php endif ?>
	<?php endif ?>
</p>

<table>
	<thead>
		<tr>
			<th>Задание</th>
			<th>Приоритет</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($_tasksInSequenceManual->count() > 0): ?>
			<tr class="note-bg">
				<td colspan="3">Задания, доступные для выбора вручную</td>
			</tr>
			<?php foreach ($_tasksInSequenceManual as $task): ?>
				<tr>
					<td><?php echo $task->name ?></td>
					<td>
						<?php
						$priority = $_teamState->getPriorityOfTask($task->getRawValue());
						echo is_bool($priority) ? '(нет)' : decorate_number($priority);
						?>
					</td>
					<td>
						<span class="button-info"><?php echo link_to('Назначить', 'gameControl/setNext?teamState='.$_teamState->id.'&taskId='.$task->id, array ('method' => 'post')) ?></span>
					</td>			
				</tr>
			<?php endforeach; ?>
		<?php endif ?>

		<?php if ($_tasksInSequence->count() > 0): ?>
			<tr class="note-bg">
				<td colspan="3">Задания, доступные согласно логике переходов</td>
			</tr>
			<?php foreach ($_tasksInSequence as $task): ?>
				<tr>
					<td><?php echo $task->name ?></td>
					<td>
						<?php
						$priority = $_teamState->getPriorityOfTask($task->getRawValue());
						echo is_bool($priority) ? '(нет)' : decorate_number($priority);
						?>
					</td>
					<td>
						<span class="button-info"><?php echo link_to('Назначить', 'gameControl/setNext?teamState='.$_teamState->id.'&taskId='.$task->id, array ('method' => 'post')) ?></span>
					</td>			
				</tr>
			<?php endforeach; ?>
		<?php endif ?>

		<?php if ($_tasksNonSequence->count() > 0): ?>
			<tr class="note-bg">
				<td colspan="3"><span class="warn">Задания, нарушающие логику переходов</span></td>
			</tr>
			<?php foreach ($_tasksNonSequence as $task): ?>
				<tr>
					<td><?php echo $task->name ?></td>
					<td>
						<?php
						$priority = $_teamState->getPriorityOfTask($task->getRawValue());
						echo is_bool($priority) ? '(нет)' : decorate_number($priority);
						?>
					</td>
					<td>
						<span class="button-warn"><?php echo link_to('Назначить', 'gameControl/setNext?teamState='.$_teamState->id.'&taskId='.$task->id, array ('method' => 'post')) ?></span>
					</td>			
				</tr>
			<?php endforeach; ?>
		<?php endif ?>

		<?php if ($_tasksLocked->count() > 0): ?>
			<tr class="note-bg">
				<td colspan="3"><span class="danger">Заблокированные задания</span></td>
			</tr>
			<?php foreach ($_tasksLocked as $task): ?>
				<tr>
					<td><?php echo $task->name ?></td>
					<td>
						<?php
						$priority = $_teamState->getPriorityOfTask($task->getRawValue());
						echo is_bool($priority) ? '(нет)' : decorate_number($priority);
						?>
					</td>
					<td>
						<span class="button-warn"><?php echo link_to('Назначить', 'gameControl/setNext?teamState='.$_teamState->id.'&taskId='.$task->id, array ('method' => 'post')) ?></span>
					</td>			
				</tr>
			<?php endforeach; ?>
		<?php endif ?>
	</tbody>
</table>