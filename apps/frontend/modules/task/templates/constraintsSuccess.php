<?php include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Переходы')); ?>

<table class="no-border">
	<thead>
		<?php if ($_isManager || $_isModerator): ?>
		<tr><td colspan="3"><span class="button-info"><?php echo link_to('Добавить', 'taskConstraint/new?taskId='.$_task->id); ?></span></td></tr>
		<?php endif; ?>
		<tr><th>Задание</th><th>Приоритет</th><th>&nbsp;</th></tr>
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
				<?php
				if ($_isManager || $_isModerator)
				{
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'edit' => link_to('Править', 'taskConstraint/edit?id='.$taskConstraint->id),
								'delete' => link_to(
												'Удалить',
												'taskConstraint/delete?id='.$taskConstraint->id,
												array(
													'method' => 'delete',
													'confirm' => 'Вы действительно хотите удалить правило перехода с задания '.$_task->name.' на задание '.( $targetTask ? $targetTask->name : '(отсутствует)').'?'
												)
											)
							),
							'css' => array(
								'edit' => 'info',
								'delete' => 'danger'
							)
						)
					)
				}
				?>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>