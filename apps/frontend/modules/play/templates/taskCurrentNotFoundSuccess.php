<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<p class="danger">
	У вас должно быть задание, но оно не найдено.
</p>
<p class="info">
	Скорее всего, ситуация скоро исправится, но все равно сообщите об этом организаторам.
</p>
<p>
	Обновляйте страницу время от времени.
</p>

<?php include_partial('taskFooter', array('_teamState' => $teamState)); ?>
