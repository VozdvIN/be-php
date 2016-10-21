<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<?php if ($teamState->ai_enabled): ?>
<p>
	Следующее задание для вашей команды будет через некоторое время выбрано автоматически.
</p>
<?php else: ?>
<p>
	Организаторы выбирают для вашей команды следующее задание.
</p>
<?php endif ?>

<p>
	Обновляйте страницу время от времени. Время ожидания не влияет на доступное игровое время.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
