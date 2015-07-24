<table>
	<thead>
		<tr>
			<th>Задание</th>
			<th>Результат</th>
			<th>Стартовало</th>
			<th>Длилось</th>
			<th>Подсказки</th>
			<th>Ответы</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
			<tr>
				<th colspan="7" style="text-align: left" class="note-bg"><?php echo $teamState->Team->name ?></th>
			</tr>
			<?php foreach ($teamState->taskStates as $taskState): ?>
			<?php if ($taskState->status <= TaskState::TASK_STARTED) { continue; } ?>
			<tr>
				<?php $task = DCTools::recordById($_taskStates->getRawValue(), $taskState->id)->Task; ?>
				<td><?php echo $task->name ?></td>
				<td><span class="<?php echo $taskState->getHighlightClass() ?>"><?php echo $taskState->describeStatus() ?></span></td>
				<td><?php echo Timing::timeToStr($taskState->started_at) ?></td>
				<td><?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?></td>
				<td>
					<?php foreach ($taskState->usedTips as $usedTip): ?>
						<?php $tip = DCTools::recordById($_usedTips->getRawValue(), $usedTip->id)->Tip; ?>
						<?php echo $tip->name.'('.Timing::timeToStr($usedTip->used_since).')'; ?> 
					<?php endforeach ?>
				</td>
				<td>
					<?php foreach ($taskState->postedAnswers as $postedAnswer): ?>
						<?php $webUser = DCTools::recordById($_postedAnswers->getRawValue(), $postedAnswer->id)->WebUser; ?>
						<span class="<?php echo $postedAnswer->getHighlightClass() ?>"><?php echo $postedAnswer->value.'('.$webUser->login.'@'.Timing::timeToStr($postedAnswer->post_time).')'; ?></span> 
					<?php endforeach ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>