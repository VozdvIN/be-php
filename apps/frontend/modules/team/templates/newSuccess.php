<?php render_breadcombs(array(link_to('Команды', 'team/index'))); ?>

<h2>Создание команды</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'mudule' => 'team')) ?>