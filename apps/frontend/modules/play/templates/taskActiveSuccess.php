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

<p class="border-top">
	Задание идет <?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?>.
</p>
<p>
	Завершится в <?php echo Timing::timeToStr($taskState->getTaskStopTime()) ?>.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
