<h2>Настройки команды <?php echo $form->getObject()->Team->name ?> на игру <?php echo $form->getObject()->Game->name ?></h2>

<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'teamState')) ?>