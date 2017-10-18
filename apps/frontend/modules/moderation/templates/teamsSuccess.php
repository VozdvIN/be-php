<?php include_partial('menu', array(
	'_activeItem' => 'Команды',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<?php include_partial('menuTeams', array('_activeItem' => 'Существующие')) ?>

<?php if ($_teams->count() == 0): ?>
<p>
	Нет команд ни в одном из игровых проектов.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<tr>
			<th>Название</th><th>Проект</th><th>Полное&nbsp;название</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teams as $team): ?>
		<tr>
			<td><?php echo link_to($team->name, url_for('team/show?id='.$team->id), array('target' => '_blank')); ?></td>
			<td>
				<?php if (isset($team->Region)): ?>
				<?php echo $team->Region->name ?>
				<?php else: ?>
				<span class="warn"><?php echo '(Не указан)' ?></span>
				<?php endif ?>
			</td>
			<td><?php echo $team->full_name; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>