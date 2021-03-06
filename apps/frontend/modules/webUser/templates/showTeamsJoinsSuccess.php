<?php include_partial('breadcrumbs', array('_webUser' => $_webUser)) ?>
<?php include_partial('menu', array('_activeItem' => 'Команды', '_webUser' => $_webUser, '_isSelf' => $_isSelf)) ?>
<?php include_partial('teamsMenu', array('_activeItem' => 'Заявки', '_webUser' => $_webUser)) ?>

<?php if ($_teamsCandidateTo->count() == 0): ?>
<p>
	Пользователь не подавал заявок в состав команд.
</p>
<?php else: ?>
<p>
	Пользователь подал заявки в состав команд:
</p>
<table class="no-border wide">
	<?php foreach ($_teamsCandidateTo as $teamCandidateTo): ?>
	<tr><td><?php echo link_to($teamCandidateTo->Team->name, url_for('team/showCrew?id='.$teamCandidateTo->team_id)); ?></td></tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>