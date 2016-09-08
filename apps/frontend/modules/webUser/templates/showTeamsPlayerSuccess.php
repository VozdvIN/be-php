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
			'_activeItem' => 'Игрок'
		)
	)
?>

<p class="info">
	Показаны команды из всех игровых проектов.
</p>

<?php if ($_teams->count() == 0): ?>
<p>
	Пользователь нигде не числится как рядовой игрок.
</p>
<?php else: ?>
<p>
	Пользователь числится рядовым игроком в командах:
</p>
<table class="no-border wide">
	<?php foreach ($_teams as $team): ?>
	<tr>
		<td><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>

<?php if ($_teamsCandidateTo->count() > 0): ?>
<p class="lf-before">
	Поданы заявки в состав команд:
</p>

<table class="no-border wide">
	<?php foreach ($_teamsCandidateTo as $teamCandidateTo): ?>
	<tr>
		<td><?php echo link_to($teamCandidateTo->Team->name, url_for('team/showCrew?id='.$teamCandidateTo->team_id)); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<?php endif; ?>
