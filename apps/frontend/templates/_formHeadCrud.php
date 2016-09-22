<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$module			имя модуля обработчика формы
 * string	$createAction	имя метода для обработки создания экземпляра
 * string	$updateAction	имя метода для обработки изменения экземпляра
 */

if ( ( ! isset($createAction)) || ($createAction == ''))
{
	$createAction = 'create';
}

if ( ( ! isset($updateAction)) || ($updateAction == ''))
{
	$updateAction = 'update';
}
?>

<form
	action="<?php echo url_for($module.'/'.($form->getObject()->isNew() ? $createAction : $updateAction).(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>"
	method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>
>

<table class="no-border">
	<thead style="display: none">
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