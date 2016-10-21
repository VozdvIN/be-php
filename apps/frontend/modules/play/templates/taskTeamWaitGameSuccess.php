<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<p>
	Игра начнется в <?php echo Timing::timeToStr(Timing::strToDate($teamState->Game->start_datetime)) ?>.
</p>
<p>
	После наступления момента начала игры обновите страницу.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
