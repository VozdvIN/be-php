<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<p>
	Задание завершилось.
</p>

<?php if ($taskState->status == TaskState::TASK_DONE_SUCCESS): ?>
<p class="info">
	Вы успешно выполнили задание.
</p>
<?php elseif ($taskState->status == TaskState::TASK_DONE_TIME_FAIL): ?>
<p class="warn">
	Вы не успели выполнить задание.
</p>
<?php elseif ($taskState->status == TaskState::TASK_DONE_SKIPPED): ?>
<p class="warn">
	Вы решили пропустить задание.
</p>
<?php elseif ($taskState->status == TaskState::TASK_DONE_GAME_OVER): ?>
<p class="warn">
	Задание остановлено в связи с завершением игры. Вы не успели его выполнить.
</p>
<?php elseif ($taskState->status == TaskState::TASK_DONE_BANNED): ?>
<p class="danger">
	Задание дисквалифицировано.
</p>
<?php elseif ($taskState->status == TaskState::TASK_DONE_ABANDONED): ?>
<p class="danger">
	Задание отменено организаторами.
</p>
<?php else: ?>
<p class="danger">
	Вы завершили задание, но непонятно с каким результатом. Сообщите об этом организаторам.
</p>
<?php endif; ?>

<p>
	Обновляйте страницу для получения следующего задания. Время ожидания не влияет на доступное игровое время.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
