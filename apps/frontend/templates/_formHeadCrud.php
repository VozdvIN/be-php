<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$module			часть адреса модуля обработчика формы
 */
?>

<form
	action="<?php echo url_for($module.'/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
	method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>
>

<table class="no-border">
	<thead style="display: hidden">
		<tr>
			<td>
				<?php foreach($form as $field) { echo $field->isHidden() ? $field->render() : ''; } ?>
				<?php if ( ! $form->getObject()->isNew()): ?>
				<input type="hidden" name="sf_method" value="put" />
				<?php endif; ?>
			</td>
		</tr>
	</thead>
	<tbody>