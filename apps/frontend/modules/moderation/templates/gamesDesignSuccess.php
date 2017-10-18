<?php include_partial('menu', array(
	'_activeItem' => 'Игры',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<?php include_partial('menuGames', array('_activeItem' => 'Разрабатываемые')) ?>

<?php if ($_games->count() == 0): ?>
<p>
	Нет разрабатываемых игр ни в одном из игровых проектов.
</p>
<?php else: ?>
<table class="no-border">
	<thead><tr><th>Название</th><th>Проект</th><th>Состояние</th><th>Брифинг</th><th>Старт</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_games as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, url_for('game/show?id='.$game->id), array('target' => '_blank')); ?></td>
			<td>
				<?php if ($game->region_id !== null): /*isset($game->Region) почему-то всегда false*/ ?> 
				<?php echo $game->Region->name ?>
				<?php else: ?>
				<span class="warn"><?php echo '(Не указан)' ?></span>
				<?php endif ?>
			</td>
			<td><?php echo $game->describeStatus(); ?></td>
			<td><?php echo $game->start_briefing_datetime ?></td>
			<td><?php echo $game->start_datetime ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>