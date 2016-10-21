<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Ответы')); ?>

<table>
	<thead>
		<tr><th rowspan="2">Команда</th><th colspan="4">Ответы</th>/tr>
		<tr><th>Ожидается</th><th>Верно</th><th>Проверка</th><th>Неверно</th>/tr>
	</thead>
	<tbody>
		<?php foreach ($_teamStates as $teamState): ?>
		<tr>
			<?php $taskState = $teamState->getCurrentTaskState(); ?>
			<td>
				<?php echo link_to($teamState->Team->name, 'play/task?id='.$teamState->id, array('target' => '_blank')) ?>
			</td>
			<?php if ($taskState): ?>
			<td>
				<?php foreach ($taskState->getRestAnswers() as $restAnswer) echo ' '.$restAnswer->name; ?>
			</td>
			<td>
				<span class="info">
				<?php foreach ($taskState->getGoodPostedAnswers() as $goodAnswer) echo ' '.$goodAnswer->value; ?>
				</span>
			</td>
			<td>
				<span class="warn">
				<?php foreach ($taskState->getBeingVerifiedPostedAnswers() as $beingVerifiedAnswer) echo ' '.$beingVerifiedAnswer->value; ?>
				</span>
			</td>
			<td>
				<span class="danger">
				<?php foreach ($taskState->getBadPostedAnswers() as $badAnswer) echo ' '.$badAnswer->value; ?>
				</span>
			</td>
			<?php else: ?>
			<td colspan="6">
				<span class="warn">Нет задания</span>
			</td>
			<?php endif ?>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>