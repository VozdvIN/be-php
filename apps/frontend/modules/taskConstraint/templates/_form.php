<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<form action="<?php echo url_for('taskConstraint/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '').($form->getObject()->isNew() ? '?taskId='.$task->id : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php
  //Служебные поля
  $width = get_text_block_size_ex('На задание:');
  render_form_field($form['_csrf_token'], $width);
  render_form_field($form['id'], $width);
  render_form_field($form['task_id'], $width);
  //Подсказка
  render_named_line($width, 'С задания:', $task->name);
  //Видимые поля
  render_form_field($form['target_task_id'], $width);
  render_form_field($form['priority_shift'], $width);
  ?>
  
  <?php
  //Код отправки
  render_form_commit(
      $form,
      'Сохранить',
      decorate_span(
          'warnAction',
          link_to(
              'Отмена',
              'task/show?id='.$task->id,
              array('confirm' => 'Вернуться без сохранения?'))),
      $width);
  ?>

</form>
