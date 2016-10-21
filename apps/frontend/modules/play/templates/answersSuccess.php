<?php
include_partial('menu', array('_activeItem' => 'Ответы', '_teamState' => $teamState));
$form = new SimpleAnswerForm();
?>

<?php if ($taskState->status == TaskState::TASK_ACCEPTED): ?>
<form action="<?php echo url_for('taskState/postAnswers').'?id='.$taskState->id; ?>" method="post">
	<table class="no-border" style="width: 100%">
		<tr>
			<td><?php echo $form['value']->render() ?></td>
			<td><input type="submit" value="Послать"/></td>
			<td><?php echo $form['_csrf_token']->render() ?></td>
		</tr>
	</table>
</form>
<?php elseif ($taskState->status == TaskState::TASK_CHEAT_FOUND): ?>
<p class="danger">
	Вы не можете отправлять ответы: вы сделали слишком много ошибок.
</p>
<?php elseif ($taskState->status < TaskState::TASK_ACCEPTED): ?>
<p>
	Вы сейчас не можете отправлять ответы: задание еще не стартовало.
</p>
<?php else: ?>
<p>
	Вы сейчас не можете отправлять ответы: задание завершено.
</p>
<?php endif ?>

<p class="border-bottom">
	Допустимо ошибок: <?php echo $badAnswersLeft ?>
</p>

<?php if ($taskState->status >= TaskState::TASK_ACCEPTED): ?>

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

<p class="border-bottom">
	<span class="danger">
		<?php foreach ($badAnswers as $postedAnswer) echo ' '.$postedAnswer->value ?>
	</span>
</p>

<?php endif; ?>

<p>
	Задание идет <?php echo Timing::intervalToStr($taskState->getTaskSpentTimeCurrent()) ?>.
</p>
<p>
	Завершится в <?php echo Timing::timeToStr($taskState->getTaskStopTime()) ?>.
</p>