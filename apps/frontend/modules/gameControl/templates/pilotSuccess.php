<?php
	$retUrlRaw = Utils::encodeSafeUrl(url_for('gameControl/pilot?id='.$_game->id));
	include_partial('header', array(
		'_game' => $_game,
		'_isManager' => $_isManager,
		'_retUrlRaw' => $retUrlRaw,
		'_activeTab' => 'Пилот'));
?>

<h3>Управление заданиями</h3>
<table>
	<thead>
		<tr>
			<th>Команда</th>
			<th>Задание</th>
			<th>Состояние</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<?php
				$currentTaskState = $teamState->getCurrentTaskState();
				$task = $currentTaskState ? DCTools::recordById($_tasks->getRawValue(), $currentTaskState->task_id) : false;
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
				<?php if (($currentTaskState->status == TaskState::TASK_GIVEN) && $currentTaskState->Task->isFilled()): ?>
					<span class="warn">, заполнено</span>
				<?php endif ?>
			</td>
			<td>
				<?php if ($currentTaskState->status == TaskState::TASK_GIVEN): ?>
					<?php if ($currentTaskState->Task->manual_start): ?>
						<span class="warn">Ручной старт</span>
					<?php else: ?>
						<span class="info">Автостарт</span>
					<?php endif; ?>				
					<?php if (($currentTaskState->Task->isFilled() || $currentTaskState->Task->manual_start)): ?>
						<span class="button-warn"><?php echo link_to('Старт','taskState/start?id='.$currentTaskState->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Дать старт заданию '.$task->name.' для команды '.$teamState->Team->name.' ?')) ?></span>
					<?php endif; ?>
					<span class="button-info"><?php echo link_to('Отменить','teamState/abandonTask?id='.$teamState->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отменить выдачу задания '.$task->name.' командe '.$teamState->Team->name.' ?')) ?></span>
				<?php elseif ($currentTaskState->status == TaskState::TASK_STARTED): ?>
					<span class="button-warn"><?php echo link_to('Прочесть','taskState/forceAccept?id='.$currentTaskState->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Подтвердить прочтение задания '.$task->name.' командой '.$teamState->Team->name.' ?')) ?></span>
					<span class="button-info"><?php echo link_to('Отменить','teamState/abandonTask?id='.$teamState->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отменить выдачу задания '.$task->name.' командe '.$teamState->Team->name.' ?')) ?></span>
				<?php elseif ($currentTaskState->status == TaskState::TASK_ACCEPTED): ?>
					<span class="button-danger"><?php echo link_to('Прекратить','teamState/abandonTask?id='.$teamState->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Прекратить выполнение задания '.$task->name.' командой '.$teamState->Team->name.' ?')) ?></span>
				<?php endif; ?>
			</td>
			<?php else: ?>
			<td colspan="3">
				<?php if ($teamState->status == TeamState::TEAM_FINISHED): ?>
					<p>
						<span class="info">Финишировала</span>
					</p>
				<?php else: ?>
					<p>
						<span class="warn">Нет задания</span>
						<?php if ($teamState->status == TeamState::TEAM_WAIT_TASK): ?>
							<span class="button-danger"><?php echo link_to('Финишировать','teamState/forceFinish?id='.$teamState->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Отправить команду '.$teamState->Team->name.' на финиш?')) ?></span>
						<?php endif; ?>
					</p>
				<?php endif; ?>
			</td>
			<?php endif; ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>

<h3>Текущие данные</h3>
<table>
	<thead>
		<tr>
			<th rowspan="2">Команда</th>
			<th rowspan="2">Подсказки</th>
			<th colspan="4">Ответы</th>
		</tr>
		<tr>
			<th>Ожидается</th>
			<th>Проверка</th>
			<th>Верно</th>
			<th>Неверно</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<?php
				$currentTaskState = $teamState->getCurrentTaskState();
				$taskState = $currentTaskState ? DCTools::recordById($_taskStates->getRawValue(), $currentTaskState->id) : false;
			?>
			<td>
				<?php echo $teamState->Team->name ?>
			</td>
			<?php if ($currentTaskState): ?>
			<td>
				<?php foreach ($taskState->usedTips as $usedTip): ?>
				<p><?php echo DCTools::recordById($_usedTips->getRawValue(), $usedTip->id)->Tip->name ?></p>
				<?php endforeach ?>
			</td>
			<td>
				<?php foreach ($taskState->getRestAnswers() as $restAnswer): ?>
				<p><?php echo $restAnswer->name ?></p>
				<?php endforeach ?>
			</td>
			<td>
				<?php foreach ($taskState->getBeingVerifiedPostedAnswers() as $beingVerifiedAnswer): ?>
				<p><span class="warn"><?php echo $beingVerifiedAnswer->value ?></span></p>
				<?php endforeach ?>
			</td>
			<td>
				<?php foreach ($taskState->getGoodPostedAnswers() as $goodAnswer): ?>
				<p><span class="info"><?php echo $goodAnswer->value ?></span></p>
				<?php endforeach ?>
			</td>
			<td>
				<?php foreach ($taskState->getBadPostedAnswers() as $badAnswer): ?>
				<p><span class="danger"><?php echo $badAnswer->value ?></span></p>
				<?php endforeach ?>
			</td>
			<?php else: ?>
			<td colspan="6">
				<p>
					<span class="warn">Нет задания</span>
				</p>
			</td>
			<?php endif ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>