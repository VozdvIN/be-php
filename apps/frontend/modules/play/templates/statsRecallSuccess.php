<?php include_partial('menu', array('_activeItem' => 'История', '_teamState' => $taskState->TeamState)) ?>

<table>
	<thead>
		<tr><th colspan="2"><?php echo $taskState->Task->public_name ?></th></tr>
	</thead>
	<tbody>
		<tr><th>Старт:</th><td><?php echo Timing::timeToStr($taskState->started_at) ?></td></tr>
		<tr><th>Длилось:</th><td><?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?></td></tr>
		<tr><th>Итог:</th><td><span class="<?php echo $taskState->getHighlightClass() ?>"><?php echo $taskState->describeStatus() ?></span></td></tr>
	</tbody>
</table>

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

<?php if ($taskState->status >= TaskState::TASK_ACCEPTED): ?>

<p class="note-bg" style="width: 100%">
	Ответы
</p>

<p class="border-bottom">
	<?php foreach ($restAnswers as $answer) echo ' '.$answer->info ?>
</p>

<p class="border-bottom">
	<span class="info">
	<?php foreach ($goodAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
	</span>
</p>

<p class="border-bottom">
	<span class="warn">
	<?php foreach ($beingVerifiedAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
	</span>
</p>
>
<p class="border-bottom">
	<span class="danger">
	<?php foreach ($badAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
	</span>
</p>

<?php endif ?>
