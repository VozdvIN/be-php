<h2>Правка шаблонных параметров игры &quot;<?php echo $form->getObject()->name; ?>&quot;</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'game', 'createAction' => 'templatesCreate', 'updateAction' => 'templatesUpdate')) ?>
