<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Маршруты')); ?>

<table>
	<thead>
		<tr><th rowspan="2">Команда</th><th colspan="2">Задание</th><th rowspan="2">&nbsp;</th></tr>
		<tr><th>Крайнее</th><th>Следующее</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<td>
				<?php echo link_to($teamState->Team->name, 'teamState/edit?id='.$teamState->id, array('target' => '_blank')) ?>
			</td>
			<td>
				<?php $lastKnownTaskState = $teamState->getLastKnownTaskState(); ?>
				<?php if ($lastKnownTaskState): ?>
					<?php echo link_to($lastKnownTaskState->Task->name, 'task/params?id='.$lastKnownTaskState->task_id, array('target' => '_blank')); ?>
				<?php endif ?>
			</td>
			<td>
				<?php if ($teamState->task_id > 0): ?>
					<span><?php echo link_to($teamState->Task->name, 'task/params?id='.$teamState->Task->id, array('target' => '_blank')); ?></span>
				<?php else: ?>
					<?php if ($teamState->getTasksAvailableForManualSelect()->Count() > 0): ?>
				<span class="info" style="font-style: italic;">Командой</span>
					<?php elseif ($teamState->ai_enabled): ?>
				<span class="info" style="font-style: italic;">Авто</span>
					<?php else: ?>
				<span class="warn" style="font-style: italic;">Не&nbsp;задано</span>
					<?php endif ?>
				<?php endif ?>
			</td>
			<td>
				<?php if ($_isManager): ?>
				<span class="button-warn"><?php echo link_to('Задать', 'gameControl/setNext?teamState='.$teamState->id) ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
