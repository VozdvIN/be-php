<?php
  render_breadcombs(array(
      link_to('Команды', 'team/index'),
      link_to($form->getObject()->name,
          'team/show?id='.$form->getObject()->id,
          array('confirm' => 'Вернуться без сохранения?'))
  ))
?>

<h2>Правка свойств команды &quot;<?php echo $form->getObject()->name; ?>&quot;</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'mudule' => 'team')) ?>