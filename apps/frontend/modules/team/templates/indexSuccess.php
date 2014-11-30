<?php render_breadcombs(array('Команды')); ?>

<h2>Команды</h2>

<p>
	<span class="info info-bg pad-box box">
	<?php
		if ($_isModerator)
		{
			echo link_to('Создать новую команду', 'team/new');
		}
		elseif ($_fastTeamCreate)
		{
			echo link_to('Создать новую команду', 'teamCreateRequest/new');
		}
		else
		{
			echo link_to('Подать заявку на создание команды', 'teamCreateRequest/new');
		}
		?>
	</span>
</p>

<?php if ($_teams->count() == 0): ?>
<p class="info">
	В этом игровом проекте нет команд.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_teams as $team): ?>
		<tr>
			<td><?php echo link_to($team->name, url_for('team/show?id='.$team->id)); ?></td>
			<td><?php echo $team->full_name; ?>&nbsp;</td>
			<td>
				<?php
				$sessionWebUser = $sf_user->getSessionWebUser()->getRawValue();
				if ($team->isLeader($sessionWebUser))
				{
					echo 'Вы капитан';
				}
				elseif ($team->isPlayer($sessionWebUser))
				{
					echo 'Вы игрок';
				}
				elseif ($team->isCandidate($sessionWebUser))
				{
					echo 'Вы подали заявку в состав';
				}
				?>
				&nbsp;
			</td>
		</tr>			
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if ($_teamCreateRequests->count() > 0): ?>

<?php   if ($_isModerator): ?>
<h3>Заявки на создание</h3>
<?php   else: ?>
<h3>Ваши заявки на создание</h3>
<?php   endif ?>

<table class="no-border">
	<tbody>
		<?php foreach ($_teamCreateRequests as $teamCreateRequest): ?>
		<tr>
			<td>
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'teamCreateRequest/delete?id='.$teamCreateRequest->id, array('method' => 'post')); ?></span>
				<?php if ($_isModerator || $_fastTeamCreate): ?>
				<span class="warn warn-bg pad-box box"><?php echo link_to('Создать', 'teamCreateRequest/acceptManual?id='.$teamCreateRequest->id, array('method' => 'post', 'confirm' => 'Подтвердить создание команды '.$teamCreateRequest->name.' ('.$teamCreateRequest->WebUser->login.' будет назначен ее капитаном) ?')); ?></span>
				<?php endif; ?>
			</td>
			<td><?php echo $teamCreateRequest->name; ?></td>
			<td><?php echo $teamCreateRequest->description; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php endif; ?>