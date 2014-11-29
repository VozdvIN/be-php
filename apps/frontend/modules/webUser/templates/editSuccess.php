<?php
  render_breadcombs(array(
      link_to('Участники', 'webUser/index'),
      link_to($form->getObject()->login,
          'webUser/show?id='.$form->getObject()->id,
          array('confirm' => 'Вернуться без сохранения?'))
  ))
?>

<h2>Редактирование анкеты &quot;<?php echo $form->getObject()->login ?>&quot;</h2>
<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'webUser')); ?>