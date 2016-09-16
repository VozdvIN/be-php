<?php
	include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Переходы'));
	$retUrlRaw = Utils::encodeSafeUrl(url_for('task/constraints?id='.$_task->id));
?>

<table class="no-border">
	<thead>
		<tr>
			<th>Задание</th>
			<th>Приоритет</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_taskConstraints as $taskConstraint): ?>
		<tr>
			<?php $targetTask = $taskConstraint->getTargetTaskSafe(); ?>
			<?php if ($targetTask): ?>
			<td>
				<?php echo $targetTask->name; ?>
			</td>
			<td>
				<?php echo decorate_number($taskConstraint->priority_shift); ?>
			</td>
			<?php else: ?>
			<td colspan="2">
				<p class="danger">
					Целевое задание не найдено!
				</p>
			</td>
			<?php endif; ?>
			<td>
				<?php if ($_isManager || $_isModerator): ?>
				<span class="button-info">
					<?php echo link_to('Править', 'taskConstraint/edit?id='.$taskConstraint->id); ?>
				</span>
				<span class="button-danger">
					<?php
						echo link_to(
							'Удалить',
							'taskConstraint/delete?id='.$taskConstraint->id.'&returl='.$retUrlRaw,
							array(
								'method' => 'delete',
								'confirm' => 'Вы действительно хотите удалить правило перехода с задания '.$_task->name.' на задание '.( $targetTask ? $targetTask->name : '(отсутствует)').'?'
							)
						);
					?>
				</span>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
	<tfoot>
		<?php if ($_isManager || $_isModerator): ?>
		<tr>
			<td colspan="3">
				<span class="button-info"><?php echo link_to('Добавить', 'taskConstraint/new?taskId='.$_task->id); ?></span>
			</td>
		</tr>
		<?php endif; ?>
	</tfoot>
</table>		