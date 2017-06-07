<?php include_partial('breadcrumbs') ?>

<?php if ($_teams->count() == 0): ?>
<p class="info">
	В текущем игровом проекте нет команд.
</p>
<?php else: ?>
<table class="no-border">
	</thead>
		<tr><th>Название</th><th>Полностью</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_teams as $team): ?>
		<tr>
			<td><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></td>
			<td><?php echo $team->full_name; ?>&nbsp;</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<p class="info">
	Показаны команды только текущего игрового проекта.
</p>
<?php endif; ?>