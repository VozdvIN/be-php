<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<p>
	Вам назначено следующее задание, оно начнется в ближайшее время.
</p>

<?php if ($taskState->Task->manual_start): ?>
<p class="info">
	Старт этому заданию организаторы дадут вручную, ожидайте.
</p>

<?php endif ?>
<?php if ($taskState->Task->isFilled()): ?>
<p class="info">
	На задании сейчас нет свободных мест. Ожидайте, пока оно освободится.
</p>
<?php endif ?>

<p>
	Обновляйте страницу время от времени для получения задания. Время ожидания не влияет на доступное игровое время.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
