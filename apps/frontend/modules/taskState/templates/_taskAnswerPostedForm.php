<?php
/**
 * Входные аргументы:
 * - $form - привязанная к "полуфабрикату" ответа форма.
 * - $returl - адрес обратного перехода (шифрованный)
 */

/* HACK: приходится отправлять оба параметра в CGI-формате, так как...
 * при попытке url_for от всей строки returl остается в CGI-формате, после
 * чего оказывается невидим в getParameter на принимающей стороне.
 */
?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('taskState/postAnswers').'?id='.$id.'&returl='.$retUrl; ?>" method="post">
	<table class="no-border" style="width: 100%">
		<tr>
			<td><?php echo $form['value']->render() ?></td>
			<td><input type="submit" value="Послать"/></td>
			<td><?php echo $form['_csrf_token']->render() ?></td>
		</tr>
	</table>
</form>