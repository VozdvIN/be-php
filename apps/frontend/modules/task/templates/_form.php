<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<form action="<?php echo url_for('task/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  
  <?php
  //Служебные поля
  $width = get_text_block_size_ex('Когда кем-то выполняется:');
  render_form_field($form['_csrf_token'], $width);
  render_form_field($form['id'], $width);
  render_form_field($form['game_id'], $width);
  ?>
  <h4>Основные</h4>
  <?php
  render_form_field($form['name'], $width);
  render_form_field($form['public_name'], $width);
  render_form_field($form['time_per_task_local'], $width);
  render_form_field($form['try_count_local'], $width);
  render_form_field($form['min_answers_to_success'], $width);
  ?>
  <h4>Управление</h4>
  <?php
  render_form_field($form['max_teams'], $width);
  render_form_field($form['manual_start'], $width);
  render_form_field($form['locked'], $width);
  ?>
  <h4>Приоритеты опорные</h4>
  <?php
  render_form_field($form['priority_free'], $width);
  render_form_field($form['priority_busy'], $width);
  ?>
  <h4>Приоритеты дополнительные</h4>
  <?php
  render_form_field($form['priority_filled'], $width);
  render_form_field($form['priority_per_team'], $width);
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
              'task/show?id='.$form->getObject()->getId(),
              array('confirm' => 'Вернуться без сохранения?'))),
      $width);
  ?>
  
</form>
