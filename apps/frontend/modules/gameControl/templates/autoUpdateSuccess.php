<!DOCTYPE html>

<div>Следующий через <span id="timerDisplay">0</span>&nbsp;с</div>

<div style="width: 50%; height: 6em">
  <iframe id="pollResults" width="100%" height="100%" src="<?php echo url_for('gameControl/poll?id='.$_game->id); ?>"></iframe>
</div>
 

<script type="text/javascript">
  function timer() {
    var timerDisplay = document.getElementById('timerDisplay');
    timerDisplay.innerHTML--;
	  
    if((+timerDisplay.innerHTML) <= 0) {
      timerDisplay.innerHTML = '<?php echo $_game->update_interval ?>';
      document.getElementById("pollResults").contentWindow.location.href = '<?php echo url_for('gameControl/poll?id='.$_game->id); ?>';
    }
    setTimeout(timer, 1000);
  }
  setTimeout(timer, 1000);
</script>