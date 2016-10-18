<?php
/* Входные данные:
 * $_game - игра
 * $_isManager - пользователь - руководитель игры
 * $_activeTab - активная страница
 */
?>

<h2>Управление игрой <?php echo $_game->name ?></h2>

<p>
	<span class="button"><?php echo link_to('Редактор', 'gameEdit/promo?id='.$_game->id, array('target' => '_blank')); ?></span>
	<span class="button"><?php echo Timing::dateToStr($_game->game_last_update) ?>&nbsp;-&nbsp;<?php echo $_game->describeStatus() ?></span>
	<?php if ($_isManager): ?>
		<?php if (($_game->status >= Game::GAME_STEADY) && ($_game->status <= Game::GAME_FINISHED)): ?>
			<span class="button-warn"><?php echo link_to('Пересчитать', 'gameControl/update?id='.$_game->id, array('method' => 'post')); ?></span>
			<span class="button"><?php echo link_to('Автопересчет', url_for('gameControl/autoUpdate?id='.$_game->id), array('target' => '_blank')) ?></span>  
		<?php endif; ?>	
		<?php if ($_game->status == Game::GAME_PLANNED): ?>
			<span class="button-info"><?php echo link_to('Подготовить к запуску', 'gameControl/verify?id='.$_game->id, array('method' => 'post', 'confirm' => 'Подготовить игру '.$_game->name.' к запуску?')); ?></span>
		<?php elseif ($_game->status == Game::GAME_VERIFICATION): ?>
			<span class="button-info"><?php echo link_to('Повторить проверку', 'gameControl/verify?id='.$_game->id, array('method' => 'post', 'confirm' => 'Повторить предстартовую проверку игры '.$_game->name.'?')); ?></span>
		<?php elseif ($_game->status == Game::GAME_READY): ?>
			<span class="button-warn"><?php echo link_to('Запустить', 'gameControl/start?id='.$_game->id, array('method' => 'post', 'confirm' => 'Запустить игру '.$_game->name.'?')); ?></span>
			<span class="button-info"><?php echo link_to('Повторить проверку', 'gameControl/verify?id='.$_game->id, array('method' => 'post', 'confirm' => 'Повторить предстартовую проверку игры '.$_game->name.'?')); ?></span>
		<?php elseif (($_game->status == Game::GAME_STEADY) || ($_game->status == Game::GAME_ACTIVE)): ?>
			<span class="button-danger"><?php echo link_to('Завершить', 'gameControl/stop?id='.$_game->id, array('method' => 'post', 'confirm' => 'Остановить игру '.$_game->name.'?')); ?></span>
		<?php elseif ($_game->status == Game::GAME_FINISHED): ?>
			<span class="button-warn"><?php echo link_to('Сдать в архив', 'gameControl/close?id='.$_game->id, array('method' => 'post', 'confirm' => 'Игру больше нельзя будет редактировать! Вы уверены, что хотите сдать в архив игру '.$_game->name.'?')); ?></span>
		<?php endif; ?>
		<?php	if ($_game->status > Game::GAME_PLANNED): ?>
			<span class="button-danger"><?php echo link_to('Перезапустить', 'gameControl/reset?id='.$_game->id, array('method' => 'post', 'confirm' => 'Перезапустить игру '.$_game->name.'?'));?></span>
		<?php endif; ?>
	<?php endif; ?>
</p>

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