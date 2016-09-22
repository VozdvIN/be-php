<h2>Правка информации об игре &quot;<?php echo $form->getObject()->name; ?>&quot;</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'gameEdit', 'createAction' => 'promoCreate', 'updateAction' => 'promoUpdate')) ?>
