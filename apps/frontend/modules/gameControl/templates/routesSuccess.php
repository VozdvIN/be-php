<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Маршруты')); ?>

<table>
	<thead>
		<th>Команда</th><th>Крайнее</th><th>Следующее</th><th>&nbsp;</th>
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
					<?php echo $lastKnownTaskState->Task->name ?> -&nbsp;<span class="<?php echo $lastKnownTaskState->getHighlightClass() ?>"><?php echo $lastKnownTaskState->describeStatus() ?></span>
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
