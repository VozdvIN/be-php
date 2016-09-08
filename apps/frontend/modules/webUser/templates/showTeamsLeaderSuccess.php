<?php
	include_partial(
		'menu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => 'Команды'
		)
	)
?>

<?php if ($_isSelf): ?>
<p class="info">
	Это ваша анкета.
</p>
<?php endif ?>

<?php
	include_partial(
		'teamsMenu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => 'Капитан'
		)
	)
?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>

<?php if ($_teams->count() == 0): ?>
<p>
	Пользователь не является капитаном ни одной из команд.
</p>
<?php else: ?>
<p>
	Пользователь руководит командами:
</p>
<table class="no-border wide">
	<?php foreach ($_teams as $team): ?>
	<tr>
		<td><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>

<p class="lf-before">
	Поданы заявки на создание команд:
</p>

<?php if($_teamCreateRequests->count() > 0): ?>
<table class="no-border wide">
	<thead>
		<tr>
			<th>Название</th>
			<th>Сообщение</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_teamCreateRequests as $teamCreateRequest): ?>
		<tr>
			<td><?php echo $teamCreateRequest->name; ?></td>
			<td><?php echo $teamCreateRequest->description; ?></td>
			<td>
				<?php if ($teamCreateRequest->web_user_id == $_webUser->id): ?>
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'teamCreateRequest/delete?id='.$teamCreateRequest->id, array('method' => 'post')); ?></span>
				<?php else: ?>
				&nbsp;
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<p>
	<span class="info info-bg pad-box box"><?php echo link_to('Создать команду', 'teamCreateRequest/new'); ?></span>
</p>