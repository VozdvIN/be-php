<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Штурман')); ?>

<h3>Карта игровой ситуации</h3>

<table>
	<thead>
		<th style="font-weight: bold">Команда</th>
		<?php foreach ($_tasks as $task): ?>
		<th>
			<span class="
				<?php
					if ($task->locked) { echo 'danger'; }
					elseif ($task->getNotDoneTaskStates()->count() == 0) { echo 'info'; }
					elseif ($task->isFilled()) { echo 'warn'; }
					else { echo ''; }
				?>
				"><?php echo $task->name ?></span>
		</th>
		<?php endforeach ?>
	</tr>
	</thead>

	<tbody>
	<?php foreach ($_teamStates as $teamState): ?>
	<tr>
		<td>
			<?php echo $teamState->Team->name; ?>
		</td>
		<?php foreach ($_tasks->getRawValue() as $task): ?>
		<td>
			<?php $knownTaskState = $teamState->findKnownTaskState($task); ?>
			<?php if ($knownTaskState): ?>
				<span class="<?php echo $knownTaskState->getHighlightClass()?>"><?php echo $knownTaskState->describeStatus() ?></span>
			<?php else: ?>
				<?php $priority = $teamState->getPriorityOfTask($task); ?>
				<span><?php echo ($priority !== false) ? decorate_number($priority) : '&nbsp;-&nbsp;' ?></span>
			<?php endif ?>
		</td>
		<?php endforeach ?>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>

<h3>Порядок заданий</h3>

<table>
	<thead>
		<th>Команда</th>
		<th>Предыдущее</th>
		<th>Текущее</th>
		<th>Следующее</th>
		<th>&nbsp;</th>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<td>
				<?php echo link_to($teamState->Team->name, 'teamState/edit?id='.$teamState->id, array('target' => '_blank')) ?>
			</td>
			<td>
				<?php $lastKnownTaskState = $teamState->getLastDoneTaskState(); ?>
				<?php if ($lastKnownTaskState): ?>
					<?php $lastKnownTask = DCTools::recordById($_tasks->getRawValue(), $lastKnownTaskState->task_id); ?>
					<?php echo $lastKnownTask->name ?>&nbsp;-&nbsp;<span class="<?php echo $lastKnownTaskState->getHighlightClass() ?>"><?php echo $lastKnownTaskState->describeStatus() ?></span>
				<?php else: ?>
					&nbsp;-&nbsp;
				<?php endif ?>
			</td>
			<td>
				<?php $currentTaskState = $teamState->getLastKnownTaskState(); ?>
				<?php if ($currentTaskState): ?>
					<?php $currentTask = DCTools::recordById($_tasks->getRawValue(), $currentTaskState->task_id); ?>
					<?php echo $currentTask->name ?>
				<?php else: ?>
					&nbsp;-&nbsp;
				<?php endif ?>
			</td>
			<td>
				<?php if ($teamState->task_id > 0): ?>
					<?php $nextTask = DCTools::recordById($_tasks->getRawValue(), $teamState->task_id); ?>
					<span><?php echo link_to($nextTask->name, 'task/params?id='.$nextTask->id, array('target' => '_blank')); ?></span>
				<?php else: ?>
					<?php if ($teamState->ai_enabled): ?>
						<span class="info">Автоматически</span>
					<?php else: ?>
						<span class="warn">Не&nbsp;задано</span>
					<?php endif ?>
				<?php endif ?>
			</td>
			<td>
				<span class="button-warn"><?php echo link_to('Задать', 'gameControl/setNext?teamState='.$teamState->id) ?></span>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
