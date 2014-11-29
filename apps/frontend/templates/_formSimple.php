<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$url			адрес обработчика формы
 * string	$commitLabel	название кнопки отправки формы
 */
?>

<?php include_partial('global/formHead', array('form' => $form, 'url' => $url)); ?>

<?php
foreach($form as $field)
{
	if ( ! $field->isHidden())
	{
		include_partial('global/formField', array('field' => $field));
	}
}
?>

<?php include_partial('global/formFoot', array('form' => $form, 'commitLabel' => $commitLabel)); ?>