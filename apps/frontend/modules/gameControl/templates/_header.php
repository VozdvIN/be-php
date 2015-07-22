<?php
/* Входные данные:
 * $_game - игра
 * $_isManager - пользователь - руководитель игры
 * $_retUrlRaw - ссылка для обратного перехода
 * $_activeTab - активная страница
 */
?>

<h2>Управление игрой <?php echo $_game->name ?></h2>

<div>
	<span class="pad-box box"><?php echo link_to('Редактор', 'game/promo?id='.$_game->id, array('target' => '_blank')); ?></span>
	<span class="pad-box box"><?php echo Timing::timeToStr($_game->game_last_update) ?>&nbsp;-&nbsp;<?php echo $_game->describeStatus() ?></span>
	<?php if ($_isManager): ?>
		<?php if (($_game->status >= Game::GAME_STEADY) && ($_game->status <= Game::GAME_FINISHED)): ?>
			<span class="warn warn-bg pad-box box"><?php echo link_to('Пересчитать', 'gameControl/update?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post')); ?></span>
			<span class="pad-box box"><?php echo link_to('Автопересчет', url_for('gameControl/autoUpdate?id='.$_game->id), array('target' => '_blank')) ?></span>  
		<?php endif; ?>	
		<?php if ($_game->status == Game::GAME_PLANNED): ?>
			<span class="info info-bg pad-box box"><?php echo link_to('Подготовить к запуску', 'gameControl/verify?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Подготовить игру '.$_game->name.' к запуску?')); ?></span>
		<?php elseif ($_game->status == Game::GAME_VERIFICATION): ?>
			<span class="info info-bg pad-box box"><?php echo link_to('Повторить проверку', 'gameControl/verify?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Повторить предстартовую проверку игры '.$_game->name.'?')); ?></span>
		<?php elseif ($_game->status == Game::GAME_READY): ?>
			<span class="warn warn-bg pad-box box"><?php echo link_to('Запустить', 'gameControl/start?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Запустить игру '.$_game->name.'?')); ?></span>
			<span class="info info-bg pad-box box"><?php echo link_to('Повторить проверку', 'gameControl/verify?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Повторить предстартовую проверку игры '.$_game->name.'?')); ?></span>
		<?php elseif (($_game->status == Game::GAME_STEADY) || ($_game->status == Game::GAME_ACTIVE)): ?>
			<span class="danger danger-bg pad-box box"><?php echo link_to('Завершить', 'gameControl/stop?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Остановить игру '.$_game->name.'?')); ?></span>
		<?php elseif ($_game->status == Game::GAME_FINISHED): ?>
			<span class="warn warn-bg pad-box box"><?php echo link_to('Сдать в архив', 'gameControl/close?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Игру больше нельзя будет редактировать! Вы уверены, что хотите сдать в архив игру '.$_game->name.'?')); ?></span>
		<?php endif; ?>
		<?php	if ($_game->status > Game::GAME_PLANNED): ?>
			<span class="danger danger-bg pad-box box"><?php echo link_to('Перезапустить', 'gameControl/reset?id='.$_game->id.'&returl='.$_retUrlRaw, array('method' => 'post', 'confirm' => 'Перезапустить игру '.$_game->name.'?'));?></span>
		<?php endif; ?>
	<?php endif; ?>
</div>

<?php if (( ! $_game->teams_can_update) && $_game->isActive() && (Timing::isExpired(time(), $_game->update_interval_max, $_game->game_last_update))): ?>
<p class="danger">
	Пересчет просрочен на <?php echo Timing::intervalToStr(time() - $_game->game_last_update - $_game->update_interval_max) ?>!</span>
</p>
<?php endif ?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeTab,
		'items' => array(
			'Пилот'=> 'gameControl/pilot?id='.$_game->id,
			'Штурман' => 'gameControl/sturman?id='.$_game->id,
			'Бортмеханик' => 'gameControl/engineer?id='.$_game->id,
			'Стюардесса' => 'gameControl/stuart?id='.$_game->id,
		)
	));
?>