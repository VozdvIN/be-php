<h2>Настройки команды <?php echo $_teamState->Team->name ?> на игру <?php echo $_teamState->Game->name ?></h2>

<?php
render_h3_inline_begin('Основные');
if ($_sessionCanManage) echo ' '.decorate_span('safeAction', link_to('Редактировать', 'teamState/edit?id='.$_teamState->id));
render_h3_inline_end();
?>
<?php
$width = get_text_block_size_ex('Автоматический выбор заданий:');
render_named_line($width, 'Задержка старта:', ($_teamState->start_delay > 0) ? Timing::intervalToStr($_teamState->start_delay) : 'Нет');
render_named_line($width, 'Автоматический выбор заданий:', ($_teamState->ai_enabled ? 'Да' : 'Нет'));
?>
