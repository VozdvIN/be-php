<?php 
	$this->_retUrlRaw = Utils::encodeSafeUrl(url_for('game/index'));
?>

<h2>Игры</h2>

<p>
	<span class="info info-bg pad-box box">
		<?php
		echo $_isGameModerator
			? link_to('Создать новую игру', 'game/new')
			: link_to('Подать заявку на создание игры', 'gameCreateRequest/newManual');
		?>
	</span>
</p>

<?php if ( ($_plannedGames->count() == 0) && ($_activeGames->count() == 0) && ($_archivedGames->count() == 0)): ?>
<p clas="info">
	Игр пока нет.
</p>
<?php endif ?>

<?php if ($_activeGames->count() > 0): ?>
<h4>Проходят сейчас</h4>
<table class="no-border">
	<tbody>
		<?php foreach ($_activeGames as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/info?id='.$game->id); ?></td>
			<td>
				<?php
					switch ($game->status)
					{
						case Game::GAME_VERIFICATION:
						case Game::GAME_READY:
						case Game::GAME_STEADY:
							echo 'стартует '.$game->start_datetime;
							break;
						case Game::GAME_ACTIVE:
							echo 'закончится '.$game->stop_datetime;
							break;
						case Game::GAME_FINISHED:
							echo 'финишировала, подведение итогов '.$game->finish_briefing_datetime;
							break;
					}
				?>
			</td>
			<td>
				<?php if ($_isActorIndex[$game->id]): ?>
					<?php echo link_to('Редактор', 'game/promo?id='.$game->id, array('target' => 'new')) ?>
					<?php echo link_to('Проведение', 'gameControl/pilot?id='.$game->id, array('target' => 'new')) ?>
				<?php endif; ?>
				&nbsp;
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if ($_plannedGames->count() > 0): ?>
<h4>Запланированы</h4>
<table class="no-border">
	<tbody>
		<?php foreach ($_plannedGames as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/info?id='.$game->id); ?></td>
			<td><?php echo 'брифинг '.$game->start_briefing_datetime; ?></td>
			<td>
				<?php if ($_isActorIndex[$game->id]): ?>
					<?php echo link_to('Редактор', 'game/promo?id='.$game->id, array('target' => 'new')) ?>
					<?php echo link_to('Проведение', 'gameControl/pilot?id='.$game->id, array('target' => 'new')) ?>
				<?php endif; ?>
				&nbsp;
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if ($_archivedGames->count() > 0): ?>
<h4>Завершены</h4>
<table class="no-border">
	<tbody>
		<?php foreach ($_archivedGames as $game): ?>
		<tr>
			<td><?php echo link_to($game->name, 'game/info?id='.$game->id); ?></td>
			<td><?php echo link_to('итоги', 'gameControl/report?id='.$game->id) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>

<?php if ($_gameCreateRequests->count() > 0): ?>
<h3><?php echo $_isGameModerator ? 'Заявки' : 'Ваши заявки'; ?></h3>
<table class="no-border">
	<tbody>
		<?php foreach ($_gameCreateRequests as $gameCreateRequest): ?>
		<tr>
			<td><?php echo $gameCreateRequest->name; ?></td>
			<td><?php echo $gameCreateRequest->description; ?></td>
			<td><?php echo link_to($gameCreateRequest->Team->name, 'team/show?id='.$gameCreateRequest->team_id, array('target' => 'new')); ?></td>
			<td>
				<span class="info info-bg pad-box box"><?php echo link_to('Отменить', 'gameCreateRequest/delete?id='.$gameCreateRequest->id, array('method' => 'post')); ?></span>
				<?php if ($_isGameModerator): ?>
				<span class="warn warn-bg pad-box box"><?php link_to('Создать', 'gameCreateRequest/acceptManual?id='.$gameCreateRequest->id, array('method' => 'post', 'confirm' => 'Подтвердить создание игры '.$gameCreateRequest->name.' ('.$gameCreateRequest->Team->name.' будут ее организаторами) ?')); ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>