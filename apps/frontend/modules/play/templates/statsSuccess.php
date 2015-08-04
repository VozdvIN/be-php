<?php include_partial('menu', array('_activeItem' => 'История', '_teamState' => $teamState)) ?>

<table>
	<thead>
		<tr>
			<th>Задание</th>
			<th>Старт</th>
			<th>Длилось</th>
			<th>Итог</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($teamState->taskStates as $taskState): ?>
		<tr>
			<td><?php echo link_to($taskState->Task->public_name, 'play/statsRecall?id='.$taskState->id) ?></td>
			<td><?php echo Timing::timeToStr($taskState->started_at) ?></td>
			<td><?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?></td>
			<td><span class="<?php echo $taskState->getHighlightClass() ?>"><?php echo $taskState->describeStatus() ?></span></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

