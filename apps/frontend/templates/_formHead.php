<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$url			адрес обработчика формы
 */
?>
<?php echo $form->renderFormTag(url_for($url)); ?>
<table class="no-border">
	<thead style="display: hidden">
		<tr>
			<td>
				<?php foreach($form as $field) { echo $field->isHidden() ? $field->render() : ''; } ?>
			</td>
		</tr>
	</thead>
	<tbody>