<?php include_partial('menu', array('_activeItem' => 'История', '_teamState' => $taskState->TeamState)) ?>

<h1>Задание <?php echo $taskState->Task->public_name ?></h1>

<h2>Результат</h2>

<table>
	<tbody>
		<tr><th>Старт:</th><td><?php echo Timing::timeToStr($taskState->started_at) ?></td></tr>
		<tr><th>Длилось:</th><td><?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?></td></tr>
		<tr><th>Итог:</th><td><span class="<?php echo $taskState->getHighlightClass() ?>"><?php echo $taskState->describeStatus() ?></span></td></tr>
	</tbody>
</table>

<h2>Подсказки</h2>

<?php foreach ($taskState->usedTips as $usedTip): ?>
<?php	if ($usedTip->status == UsedTip::TIP_USED): ?>
<p class="note-bg" style="width: 100%">
	<?php echo Timing::timeToStr($usedTip->used_since) ?>
</p>
<section>
	<?php echo Utils::decodeBB($usedTip->Tip->define) ?>
</section>
<?php	endif; ?>
<?php endforeach; ?>

<h2>Ответы</h2>

<?php if ($restAnswers->count() > 0): ?>
	<p>
	<?php foreach ($restAnswers as $answer): ?>
		<span><?php echo $answer->info ?> </span>
	<?php endforeach ?>
	</p>
<?php endif ?>

<?php if ($goodAnswers->count() > 0): ?>
	<p>
	<?php foreach ($goodAnswers as $postedAnswer): ?>
		<span class="info"><?php echo $postedAnswer->value ?> </span>
	<?php endforeach ?>
	</p>
<?php endif ?>

<?php if ($beingVerifiedAnswers->count() > 0): ?>
	<p>
	<?php foreach ($beingVerifiedAnswers as $postedAnswer): ?>
		<span class="warn"><?php echo $postedAnswer->value ?> </span>
	<?php endforeach ?>
	</p>
<?php endif ?>

<?php if ($badAnswers->count() > 0): ?>
	<p>
	<?php foreach ($badAnswers as $postedAnswer): ?>
		<span class="danger"><?php echo $postedAnswer->value ?> </span>
	<?php endforeach ?>
	</p>
<?php endif ?>

