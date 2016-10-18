<!DOCTYPE html>
<h2>Пересчет состояния игры <?php echo $_game->name ?></h2>
<span class="button"><?php echo link_to('Редактор', 'gameEdit/promo?id='.$_game->id, array('target' => '_blank')); ?></span>
<span class="button"><?php echo link_to('Управление', 'gameControl/state?id='.$_game->id, array('target' => '_blank')); ?></span>
<p>
	Следующий через <span id="timerDisplay">0</span>&nbsp;с
	<iframe style="width: 100%; height: 2cm" id="pollResults" width="100%" height="100%" src="<?php echo url_for('gameControl/poll?id='.$_game->id); ?>"></iframe>
</p>
<script type="text/javascript">
	function timer() {
		var timerDisplay = document.getElementById('timerDisplay');
		timerDisplay.innerHTML--;
		if ((+timerDisplay.innerHTML) <= 0) {
			timerDisplay.innerHTML = '<?php echo $_game->update_interval ?>';
			document.getElementById("pollResults").contentWindow.location.href = '<?php echo url_for('gameControl/poll?id='.$_game->id); ?>';
		}
		setTimeout(timer, 1000);
	}
	setTimeout(timer, 1000);
</script>