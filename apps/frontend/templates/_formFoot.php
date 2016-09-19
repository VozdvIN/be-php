<?php
/* Входные аргументы:
 * string	$commitLabel	название кнопки отправки формы
 */
$requiredNote = false;
foreach($form as $field)
{
	if (strpos($field->renderLabel(), '*') !== false) // TODO: Почему-то ни разу не в нулевой или первой позиции зведзочка оказывается...
	{
		$requiredNote = true;
		break;
	}
}
?>
	</tbody>
	<tfoot>
		<?php if ($requiredNote): ?><tr><td colspan="3"><p class="info">Поля со звездочкой обязательны для заполнения.</p></td></tr><?php endif; ?>
		<tr><th>&nbsp;</th><td colspan="2"><input type="submit" value="<?php echo $commitLabel?>" /></td></tr>
	</tfoot>
</table>
<?php echo '</form>'; ?>