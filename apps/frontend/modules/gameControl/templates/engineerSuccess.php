<?php
	$retUrlRaw = Utils::encodeSafeUrl(url_for('gameControl/engineer?id='.$_game->id));
	include_partial('header', array(
		'_game' => $_game,
		'_isManager' => $_isManager,
		'_retUrlRaw' => $retUrlRaw,
		'_activeTab' => 'Бортмеханик'));
?>

<h3>Задания</h3>

<table>
	<thead>
		<tr>
			<th>Название</th>
			<th>Состояние</th>
			<th>Выдано, стартовало, прочитано, завершено</th>
			<th>Простой</th>
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
			<tr>
				<td><?php echo $taskState->Task->name ?></td>
				<td><?php echo $taskState->describeStatus() ?></td>
				<td>
					<?php echo Timing::timeToStr($taskState->given_at) ?>,
					<?php echo Timing::timeToStr($taskState->started_at) ?>,
					<?php echo Timing::timeToStr($taskState->accepted_at) ?>,
					<?php echo Timing::timeToStr($taskState->done_at) ?>
				</td>
				<td><?php echo Timing::intervalToStr($taskState->task_idle_time) ?></td>
				<td><?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?></td>
				<td>
					<?php foreach ($taskState->usedTips as $usedTip): ?>
						<?php $tip = DCTools::recordById($_usedTips->getRawValue(), $usedTip->id)->Tip; ?>
						<span><?php echo $tip->name.'('.Timing::timeToStr($usedTip->used_since).')'; ?></span> 
					<?php endforeach ?>
				</td>
				<td>
					<?php foreach ($taskState->postedAnswers as $postedAnswer): ?>
						<?php $webUser = DCTools::recordById($_postedAnswers->getRawValue(), $postedAnswer->id)->WebUser; ?>
						<span><?php echo $postedAnswer->value.'('.$webUser->login.'@'.Timing::timeToStr($postedAnswer->post_time).')'; ?></span> 
					<?php endforeach ?>
				</td>
			</tr>
			<?php endforeach ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

<h3>Команды</h3>

<table>
	<thead>
		<tr>
			<th>Название</th>
			<th>Состояние</th>
			<th>Обновлено</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<td><?php echo $teamState->Team->name ?></td>
			<td><?php echo $teamState->describeStatus() ?></td>
			<td><?php echo Timing::timeToStr($teamState->team_last_update) ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

<h3>Игра</h3>
<table>
	<thead>
		<tr>
			<th>Состояние</th>
			<th>Обновлено</th>
			<th>Плановый старт</th>
			<th>Стартовала</th>
			<th>Плановая остановка</th>
			<th>Финишировала</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th><?php echo $_game->describeStatus() ?></th>
			<th><?php echo Timing::dateToStr($_game->game_last_update) ?></th>
			<th><?php echo $_game->start_datetime ?></th>
			<th><?php echo Timing::dateToStr($_game->started_at) ?></th>
			<th><?php echo $_game->stop_datetime ?></th>
			<th><?php echo Timing::dateToStr($_game->finished_at) ?></th>
		</tr>
	</tbody>
</table>