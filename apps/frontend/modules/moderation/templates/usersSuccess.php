<?php include_partial('menu', array(
	'_activeItem' => 'Участники',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<?php include_partial('menuUsers', array('_activeItem' => 'Все')) ?>

<?php if ($_webUsers->count() == 0): ?>
<p>
	Нет участников ни в одном из игровых проектов.
</p>
<?php else: ?>
<table class="no-border">
	<thead>
		<tr>
			<th>Имя</th><th>Ф.И.(О.)</th><th>Проект</th><th>Статус</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_webUsers as $webUser): ?>
		<tr>
			<td><?php echo link_to($webUser->login, url_for('webUser/show?id='.$webUser->id), array('target' => '_blank')); ?></td>
			<td><?php echo $webUser->full_name; ?></td>
			<td>
				<?php if ($webUser->region_id !== null): ?> 
				<?php echo $webUser->Region->name ?>
				<?php else: ?>
				<span class="warn"><?php echo '(Не указан)' ?></span>
				<?php endif ?>
			</td>
			<td><?php if ( ! $webUser->is_enabled):?><span class="warning">Блокирован</span><?php endif ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>