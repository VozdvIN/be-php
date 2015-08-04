<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<?php foreach ($taskState->usedTips as $usedTip): ?>
<?php   if ($usedTip->status == UsedTip::TIP_USED): ?>
<p class="note-bg" style="width: 100%">
	<?php echo Timing::timeToStr($usedTip->used_since) ?>
</p>
<section>
	<?php echo Utils::decodeBB($usedTip->Tip->define) ?>
</section>
<?php   endif; ?>
<?php endforeach; ?>

<?php if ($isLeader && $taskState->canBeSkipped()): ?>
<p class="border-top">
	<span class="danger danger-bg pad-box box"><?php echo link_to('Пропустить задание', 'taskState/skip?id='.$taskState->id.'&returl='.Utils::encodeSafeUrl(url_for('taskState/task?id='.$taskState->id)), array('method' => 'post', 'confirm' => 'Вы точно хотите пропустить задание?')); ?></span>
</p>
<?php endif ?>

<p class="border-top">
	Задание идет <?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?>.
</p>
<p>
	Завершится в <?php echo Timing::timeToStr($taskState->getTaskStopTime()) ?>.
</p>