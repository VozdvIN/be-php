<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<p>
	Игра началась.
</p>
<p>
	Ваша команда стартует в <?php echo Timing::timeToStr($teamState->getActualStartDateTime()) ?>.
</p>
<p>
	Обновите страницу после наступления момента старта вашей команды.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
