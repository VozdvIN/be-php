<?php
/* Входные аргументы:
 * sfForm	$field	поле для отображения
 */
?>
<tr>
	<td>
		<?php echo $field->renderLabel(); ?>
	</td>
	<td>
		<?php echo $field->render(); ?>
	</td>
	<td>
		<?php if ($field->hasError()):?>
		<p class="danger">
			<?php echo $field->getError(); ?>
		</p>
		<?php endif; ?>

		<?php $helps = explode('|', $field->getParent()->getWidget()->getHelp($field->getName())); ?>
		<?php foreach($helps as $help): ?>
		<p>
			<?php echo $help; ?>
		</p>
		<?php endforeach; ?>
	</td>
</tr>