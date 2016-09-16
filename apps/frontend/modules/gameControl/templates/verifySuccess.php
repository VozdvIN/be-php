<h2>Предстартовая проверка игры &quot;<?php echo $_game->name ?>&quot;</h2>

<?php $cannotStart = false; ?>

<?php if (isset($report['tasks'])): ?>
<h3>Проблемы заданий</h3>
<table>
	<tbody>
		<?php foreach ($report['tasks'] as $taskId => $taskReport): ?>
		<tr>
			<td><?php echo link_to(Task::byId($taskId)->name, 'task/params?id='.$taskId, array('target' => '_blank')) ?></td>
			<td>
				<ul>
					<?php foreach ($taskReport as $reportLine): ?>
						<?php if ($reportLine['errLevel'] == Game::VERIFY_ERR): ?>
							<li class="danger"><?php echo $reportLine['msg']; $cannotStart = true; ?></li>
						<?php else:?>
							<li class="info"><?php echo $reportLine['msg'] ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
		<?php endforeach; ?>		
	</tbody>
</table>
<?php endif; ?>

<?php if (isset($report['teams'])): ?>
<h3>Проблемы команд</h3>
<table>
	<tbody>
		<?php foreach ($report['teams'] as $teamId => $teamReport): ?>
		<tr>
			<td><?php echo link_to(Team::byId($teamId)->name, 'team/show?id='.$teamId, array('target' => '_blank')) ?></td>
			<td>
				<ul>
					<?php foreach ($teamReport as $reportLine): ?>
						<?php if ($reportLine['errLevel'] == Game::VERIFY_ERR): ?>
							<li class="danger"><?php echo $reportLine['msg']; $cannotStart = true; ?></li>
						<?php else:?>
							<li class="info"><?php echo $reportLine['msg'] ?></li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<h3>Вывод</h3>

<?php if ($cannotStart): ?>
	<p class="danger">Игра не может быть запущена, так как есть принципиальные проблемы.</p>
<?php else:?>
	<p class="warn">Игру можно запустить, но в ходе проведения возможны организационные проблемы.</p>
<?php endif; ?>

<p>
	<?php if ( ! $cannotStart): ?>
	<span class="button-warn"><?php echo link_to('Запустить игру', 'gameControl/start?id='.$_game->id.'&returl='.Utils::encodeSafeUrl(url_for('gameControl/pilot?id='.$_game->id)), array('method' => 'post', 'confirm' => 'Запустить игру '.$_game->name.'?')); ?></span>
	<?php endif; ?>
	<span class="button-info"><?php echo link_to('Повторить проверку', 'gameControl/verify?id='.$_game->id.'&returl='.Utils::encodeSafeUrl(url_for('gameControl/pilot?id='.$_game->id)), array('method' => 'post')); ?></span>
</p>
