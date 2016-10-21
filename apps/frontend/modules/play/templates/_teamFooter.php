<?php
/* Входные данные:
 * - $_teamState - состояние команды
 */
?>
<p class="border-top">
<strong><?php echo $_teamState->Team->name ?></strong><br>
<?php echo $_teamState->Game->name ?>
</p>