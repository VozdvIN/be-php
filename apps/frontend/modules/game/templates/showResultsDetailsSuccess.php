<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Итоги', '_editable' => $_canManage)) ?>

<?php include_partial('resultsMenu', array('_game' => $_game, '_activeItem' => 'Телеметрия')) ?>

<table>
	<thead>
		<tr><th>Задание</th><th>Результат</th><th>Старт</th><th>Длилось</th><th>Подсказки</th><th>Ответы</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
			<tr><th colspan="8" style="text-align: left" class="note-bg"><?php echo $teamState->Team->name ?></th></tr>
			<?php foreach ($teamState->taskStates as $taskState): ?>
			<?php if ($taskState->status <= TaskState::TASK_STARTED) { continue; } ?>
			<tr>
				<td><?php echo $taskState->Task->name ?></td>
				<td><span class="<?php echo $taskState->getHighlightClass() ?>"><?php echo $taskState->describeStatus() ?></span></td>
				<td><?php echo Timing::timeToStr($taskState->accepted_at) ?></td>
				<td><?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?></td>
				<td>
					<?php foreach ($taskState->usedTips as $usedTip): ?>
						<?php echo $usedTip->Tip->name.'('.Timing::timeToStr($usedTip->used_since).')'; ?> 
					<?php endforeach ?>
				</td>
				<td>
					<?php foreach ($taskState->postedAnswers as $postedAnswer): ?>
						<span class="<?php echo $postedAnswer->getHighlightClass() ?>"><?php echo $postedAnswer->value.'('.$postedAnswer->WebUser->login.'@'.Timing::timeToStr($postedAnswer->post_time).')'; ?></span> 
					<?php endforeach ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>