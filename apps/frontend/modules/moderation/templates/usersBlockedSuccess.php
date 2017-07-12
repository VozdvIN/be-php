<?php include_partial('breadcrumbs') ?>

<?php include_partial('menu', array(
	'_activeItem' => 'Участники',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<?php include_partial('menuUsers', array('_activeItem' => 'Блокированные')) ?>

<?php if ($_webUsers->count() == 0): ?>
<p>
	Нет блокированных участников.
</p>
<?php else: ?>
<table class="no-border">
	<thead><tr><th>Имя</th><th>Ф.И.(О.)</th></tr></thead>
	<tbody>
		<?php foreach ($_webUsers as $webUser): ?>
		<tr>
			<td><?php echo link_to($webUser->login, url_for('webUser/show?id='.$webUser->id), array('target' => '_blank')); ?></td>
			<td><?php echo $webUser->full_name; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>