<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Карта')); ?>

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
			<?php echo link_to($teamState->Team->name, 'play/task?id='.$teamState->id, array('target' => '_blank')) ?>
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
