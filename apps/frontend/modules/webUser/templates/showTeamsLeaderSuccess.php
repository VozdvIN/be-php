<?php include_partial('breadcrumbs', array('_webUser' => $_webUser)) ?>
<?php include_partial('menu', array('_activeItem' => 'Команды', '_webUser' => $_webUser, '_isSelf' => $_isSelf)) ?>
<?php include_partial('teamsMenu', array('_activeItem' => 'Капитан', '_webUser' => $_webUser)) ?>

<?php if ($_teams->count() == 0): ?>
<p>
	Пользователь не является капитаном ни одной из команд.
</p>
<?php else: ?>
<table class="no-border">
	<?php foreach ($_teams as $team): ?>
	<tr><td><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></td></tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>