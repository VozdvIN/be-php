<?php
	include_partial(
		'indexMenu',
		array(
			'_activeItem' => 'Капитан'
		)
	)
?>

<?php if ($_teams->count() == 0): ?>
<p>
	Вы не являетесь капитаном ни одной из команд.
</p>
<?php else: ?>
<ul>
	<?php foreach ($_teams as $team): ?>
	<li><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></li>
	<?php endforeach; ?>
</ul>
<p class="info">
	Показаны команды из всех игровых проектов.
</p>
<?php endif; ?>

<p>
	Ваши заявки на создание команд:
</p>
<p>
	<span class="pad-box box"><?php echo link_to('Создать команду', 'teamCreateRequest/new'); ?></span>
</p>
<?php if($_teamCreateRequests->size() > 0): ?>
<table class="no-border">
	<thead>
		<tr>
			<th>Будущее название</th>
			<th>Сообщение</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teamCreateRequests as $teamCreateRequest): ?>
		<tr>
			<td><?php echo $teamCreateRequest->name; ?></td>
			<td><?php echo $teamCreateRequest->description; ?></td>
			<td><span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'teamCreateRequest/delete?id='.$teamCreateRequest->id, array('method' => 'post')); ?></span></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>