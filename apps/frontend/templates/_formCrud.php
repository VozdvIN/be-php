<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$module			часть адреса модуля обработчика формы
 */

$isNew = $form->getObject()->isNew();
?>

<?php include_partial('global/formHeadCrud', array('form' => $form, 'module' => $module)); ?>

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