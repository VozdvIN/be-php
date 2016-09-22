<h2>Правка настроек игры &quot;<?php echo $form->getObject()->name; ?>&quot;</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'gameEdit', 'createAction' => 'settingsCreate', 'updateAction' => 'settingsUpdate')) ?>
