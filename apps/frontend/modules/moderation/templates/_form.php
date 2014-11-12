<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('moderation/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>  
  <?php
  //Служебные поля
  $width = get_text_block_size_ex('Cоздание команд по почте:');
  render_form_field($form['_csrf_token'], $width);
  render_form_field($form['id'], $width);
  ?>
  <h4>Реквизиты сайта</h4>
  <?php
  render_form_field($form['site_name'], $width);
  render_form_field($form['site_domain'], $width);
  render_form_field($form['contact_email_addr'], $width);
  ?>
  <h4>Модерация</h4>
  <?php
  render_form_field($form['games_announce_interval'], $width);
  render_form_field($form['email_team_create'], $width);
  render_form_field($form['email_game_create'], $width);
  render_form_field($form['fast_team_create'], $width);
  render_form_field($form['fast_user_register'], $width);
  ?>
  <h4>Отправка уведомлений</h4>
  <?php
  render_form_field($form['notify_email_addr'], $width);
  render_form_field($form['smtp_host'], $width);
  render_form_field($form['smtp_port'], $width);
  render_form_field($form['smtp_security'], $width);
  render_form_field($form['smtp_login'], $width);
  render_form_field($form['smtp_password'], $width);
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
              'moderation/show',
              array('confirm' => 'Вернуться без сохранения?'))),
      $width);
  ?>
  
</form>
