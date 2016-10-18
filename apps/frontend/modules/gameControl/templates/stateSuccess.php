<?php include_partial('menu', array('_game' => $_game, '_activeItem' => $_game->name.' (Управление)')); ?>

<?php
include_partial(
	'global/actionsMenu',
	array(
		'items' => array(
			'update' => link_to('Пересчитать', 'gameControl/update?id='.$_game->id, array('method' => 'post')),
			'autoUpdate'=> link_to('Автопересчет', 'gameControl/autoUpdate?id='.$_game->id, array('target' => '_blank'))
		),
		'css' => array(
			'update' => 'warn',
			'autoUpdate' => ''
		),
		'conditions' => array(
			'update' => ($_game->status >= Game::GAME_STEADY)
							&& ($_game->status <= Game::GAME_FINISHED),
			'autoUpdate' => ($_game->status >= Game::GAME_STEADY)
							&& ($_game->status <= Game::GAME_FINISHED)
		)
	)
);
?>

<p>
	<span>Состояние: <?php echo $_game->describeStatus() ?> (<?php echo Timing::dateToStr($_game->game_last_update) ?>)</span>
</p>

<?php if (( ! $_game->teams_can_update) && $_game->isActive() && (Timing::isExpired(time(), $_game->update_interval_max, $_game->game_last_update))): ?>
<p class="danger">
	Пересчет просрочен на <?php echo Timing::intervalToStr(time() - $_game->game_last_update - $_game->update_interval_max) ?>!</span>
</p>
<?php endif ?>

<?php
include_partial(
	'global/actionsMenu',
	array(
		'items' => array(
			'init' => link_to('Подготовить', 'gameControl/verify?id='.$_game->id, array('method' => 'post', 'confirm' => 'Подготовить игру '.$_game->name.' к запуску?')),
			'start' => link_to('Запустить', 'gameControl/start?id='.$_game->id, array('method' => 'post', 'confirm' => 'Запустить игру '.$_game->name.'?')),
			'stop' => link_to('Завершить', 'gameControl/stop?id='.$_game->id, array('method' => 'post', 'confirm' => 'Остановить игру '.$_game->name.'?')),
			'close' => link_to('Сдать в архив', 'gameControl/close?id='.$_game->id, array('method' => 'post', 'confirm' => 'Игру больше нельзя будет редактировать! Cдать в архив игру '.$_game->name.'?')),
			'reset' => link_to('Сбросить', 'gameControl/reset?id='.$_game->id, array('method' => 'post', 'confirm' => 'Перезапустить игру '.$_game->name.'?'))
		),
		'css' => array(
			'init' => 'info',
			'start' => 'warn',
			'stop' => 'danger',
			'close' => 'warn',
			'reset' => 'danger'
		),
		'conditions' => array(
			'init' => ($_game->status == Game::GAME_PLANNED)
						|| ($_game->status == Game::GAME_VERIFICATION)
						|| ($_game->status == Game::GAME_READY),
			'start' => $_game->status == Game::GAME_READY,
			'stop' => $_game->status == Game::GAME_ACTIVE,
			'close' => $_game->status == Game::GAME_FINISHED,
			'reset' => $_game->status > Game::GAME_PLANNED
		)
	)
);
?>