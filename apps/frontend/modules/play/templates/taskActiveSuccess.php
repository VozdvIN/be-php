<?php
include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState));

$timerParams = array(
	'id' => 'task',
	'time' => Timing::intervalToStr($taskState->getTaskStopTime() - time()),
	'command' => 'window.location.reload()'
);
?>
<p style="font-weight: bold"><?php echo $taskState->Task->public_name; ?></p>
<p>Осталось <?php include_partial('global/timer', $timerParams); ?> до (<?php echo Timing::timeToStr($taskState->getTaskStopTime()) ?>).</p>

<?php foreach ($taskState->usedTips as $usedTip): ?>
	<?php if ($usedTip->status == UsedTip::TIP_USED): ?>
<p class="note-bg" style="width: 100%"> <?php echo Timing::timeToStr($usedTip->used_since) ?> </p>
<section><?php echo Utils::decodeBB($usedTip->Tip->define) ?></section>
	<?php endif; ?>
<?php endforeach; ?>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>