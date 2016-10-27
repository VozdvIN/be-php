<?php
/* Входные данные:
 * - $_teamState - состояние команды
 */
?>
<p class="border-top">
<strong><?php echo $_teamState->Team->name ?></strong><br>
<?php echo link_to($_teamState->Game->name, 'game/show?id='.$_teamState->game_id, array('target' => '_blank')); ?>
</p>