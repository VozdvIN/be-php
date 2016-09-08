<?php
	include_partial(
		'indexMenu',
		array(
			'_activeItem' => 'Рядовой'
		)
	)
?>

<?php if ($_teams->count() == 0): ?>
<p>
	Вы нигде не числитесь как рядовой игрок.
</p>
<?php else: ?>
<p>
	Вы рядовой игрок в командах:
</p>
<ul>
	<?php foreach ($_teams as $team): ?>
	<li><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></li>
	<?php endforeach; ?>
</ul>
<p class="info">
	Показаны команды из всех игровых проектов.
</p>
<?php endif; ?>

<?php if ($_teamsCandidateTo->count() > 0): ?>
<p>
	Вы подали заявки в состав команд:
</p>
<ul>
	<?php foreach ($_teamsCandidateTo as $teamCandidateTo): ?>
	<li><?php echo link_to($teamCandidateTo->Team->name, url_for('team/show?id='.$teamCandidateTo->team_id)); ?></li>
	<?php endforeach; ?>
</ul>
<p class="info">
	Показаны команды из всех игровых проектов.
</p>
<?php endif; ?>