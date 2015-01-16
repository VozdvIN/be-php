<?php
/* Входные аргументы:
 * sfForm	$form			форма для отображения
 * string	$url			адрес обработчика формы
 */
?>

<p class="info">
	Поля, отмеченные звездочками, обязательны для заполнения.
</p>

<?php echo $form->renderFormTag(url_for($url)); ?>
<table class="no-border">
	<thead style="display: none">
		<tr>
			<td>
				<?php foreach($form as $field) { echo $field->isHidden() ? $field->render() : ''; } ?>
			</td>
		</tr>
	</thead>
	<tbody>