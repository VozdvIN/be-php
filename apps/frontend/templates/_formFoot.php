<?php
/* Входные аргументы:
 * string	$commitLabel	название кнопки отправки формы
 */
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="3">
				<input type="submit" value="<?php echo $commitLabel; ?>" />
			</td>
		</tr>
	</tfoot>
</table>
<?php echo '</form>'; ?>