<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<?php if ($teamState->task_id > 0): ?>
<p>
	Вам выбрано следующее задание, оно начнется в ближайшее время.
</p>
<?php elseif ($teamState->ai_enabled): ?>
<p>
	Следующее задание для вас будет выбрано автоматически.
</p>
<?php else: ?>
<p>
	Организаторы выбирают для вашей команды следующее задание, ожидайте.
</p>
<?php endif ?>

<p>
	Периодически обновляйте страницу. Время ожидания не влияет на доступное игровое время.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
