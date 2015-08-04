<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $_teamState)) ?>

<p>
	Ваша команда финишировала.
</p>

<?php if ($teamState->Game->status <= Game::GAME_FINISHED): ?>
<p>
	Результаты игры будут опубликованы после подведения ее итогов, которое состоится <?php echo $_teamState->Game->finish_briefing_datetime ?>.
</p>
<?php else: ?>
<p>
	<span class="pad-box box"><?php echo link_to('Результаты игры', 'gameControl/report?id='.$_teamState->game_id) ?></span>
</p>
<?php endif ?>