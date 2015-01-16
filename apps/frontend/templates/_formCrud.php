<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$module			часть адреса модуля обработчика формы
 * string	$createAction	имя метода для обработки создания экземпляра
 * string	$updateAction	имя метода для обработки изменения экземпляра* 
 */

if ( ! $form)
{
	throw new Exception('Templates::Global::_formCrud: $form must be set.');
}

if ( ! $module)
{
	throw new Exception('Templates::Global::_formCrud: $module must be set.');
}

if ( ( ! isset($createAction)) || ($createAction == ''))
{
	$createAction = 'create';
}

if ( ( ! isset($updateAction)) || ($updateAction == ''))
{
	$updateAction = 'update';
}

$isNew = $form->getObject()->isNew();
?>

<?php include_partial('global/formHeadCrud', array('form' => $form, 'module' => $module, 'createAction' => $createAction, 'updateAction' => $updateAction)); ?>

<?php
foreach($form as $field)
{
	if ( ! $field->isHidden())
	{
		include_partial('global/formField', array('field' => $field));
	}
}
?>

<?php include_partial('global/formFoot', array('form' => $form, 'commitLabel' => ($isNew ? 'Создать' : 'Сохранить'))); ?>