<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<form action="<?php echo url_for('teamCreateRequest/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <?php
  echo render_form(
      $form,
      'Подать заявку',
      decorate_span(
          'warnAction',
          link_to(
              'Отмена',
              'team/index',
              array('confirm' => 'Вернуться без сохранения?')))
  );
  ?>
</form>