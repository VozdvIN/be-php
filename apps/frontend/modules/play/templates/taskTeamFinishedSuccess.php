<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)) ?>

<p>
	Ваша команда финишировала.
</p>

<?php if ($teamState->Game->status <= Game::GAME_FINISHED): ?>
<p>
	Результаты игры будут опубликованы после подведения ее итогов, которое состоится <?php echo $teamState->Game->finish_briefing_datetime ?>.
</p>
<?php else: ?>
<p>
	<span class="button"><?php echo link_to('Результаты игры', 'game/showResults?id='.$teamState->game_id) ?></span>
</p>
<?php endif ?>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
