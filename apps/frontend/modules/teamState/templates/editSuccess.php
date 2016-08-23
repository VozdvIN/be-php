<h2>Настройки команды &quot;<?php echo $form->getObject()->Team->name ?>&quot; на игру &quot;<?php echo $form->getObject()->Game->name ?>&quot;</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'teamState')) ?>