<?php
/* Входные данные:
 * $teamState - состояние команды
 */
?>
<div style="font-weight: bold"><?php echo $teamState->Team->name ?></div>
<div><?php echo $teamState->Game->name ?></div>
<div class="hr">
	<span class="info info-bg pad-box box"><?php echo link_to('Обновить', 'play/task?id='.$teamState->id) ?></span>
</div>
