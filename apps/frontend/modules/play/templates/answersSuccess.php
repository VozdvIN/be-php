<?php
include_partial('menu', array('_activeItem' => 'Ответы', '_teamState' => $teamState));
$form = new SimpleAnswerForm();
?>
<?php if ($taskState->status == TaskState::TASK_ACCEPTED): ?>
<form style="width: 100%" action="<?php echo url_for('taskState/postAnswers').'?id='.$taskState->id; ?>" method="post">
<span><input type="submit" value="Послать" /></span>
<span><?php echo $form['value']->render() ?></span>
<span>Ошибок&nbsp;до&nbsp;<?php echo $badAnswersLeft ?></span>
<?php echo $form['_csrf_token']->render() ?>
</form>
<?php elseif ($taskState->status == TaskState::TASK_CHEAT_FOUND): ?>
<p class="danger">Вы не можете отправлять ответы: вы сделали слишком много ошибок.</p>
<?php elseif ($taskState->status < TaskState::TASK_ACCEPTED): ?>
<p>Вы сейчас не можете отправлять ответы: задание еще не стартовало.</p>
<?php else: ?>
<p>Вы сейчас не можете отправлять ответы: задание завершено.</p>
<?php endif ?>
<?php if ($taskState->status >= TaskState::TASK_ACCEPTED): ?>
<p class="border-top">
<?php foreach ($restAnswers as $answer) echo ' '.$answer->info ?>
</p>
<p class="border-top">
<span class="info">
<?php foreach ($goodAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
</span>
</p>
<p class="border-top">
<span class="warn">
<?php foreach ($beingVerifiedAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
</span>
</p>
<p class="border-top">
<span class="danger">
<?php foreach ($badAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
</span>
</p>
<?php endif; ?>
<p class="border-top">Задание идет <?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?>.</p>
<p>Завершится в <?php echo Timing::timeToStr($taskState->getTaskStopTime()) ?>.</p>
<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
