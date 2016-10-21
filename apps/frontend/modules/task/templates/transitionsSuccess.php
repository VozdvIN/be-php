<?php include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Фильтры')); ?>

<table class="no-border">
	<thead>
		<?php if ($_isManager || $_isModerator): ?>
		<tr><td colspan="4"><span class="button-info"><?php echo link_to('Добавить', 'taskTransition/new?taskId='.$_task->id); ?></span></td></tr>
		<?php endif; ?>
		<tr><th>Задание</th><th>Переход</th><th>Вручную</th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_taskTransitions as $taskTransition): ?>
		<tr>
			<?php $targetTask = $taskTransition->getTargetTaskSafe(); ?>
			<?php if ($targetTask): ?>
			<td>
				<?php echo $targetTask->name; ?>
			</td>
			<td>
				<?php if ($taskTransition->allow_on_success && $taskTransition->allow_on_fail): ?>
				Всегда
				<?php elseif ($taskTransition->allow_on_success): ?>
				<span class="info">При&nbsp;успехе</span>
				<?php else: ?>
				<span class="warn">При&nbsp;неудаче</span>
				<?php endif; ?>
			</td>
			<td>
				<?php echo $taskTransition->manual_selection ? 'Да' : ''; ?>
			</td>
			<?php else: ?>
			<td colspan="3">
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
								'edit' => link_to('Править', 'taskTransition/edit?id='.$taskTransition->id),
								'delete' => link_to(
												'Удалить',
												'taskTransition/delete?id='.$taskTransition->id,
												array(
													'method' => 'delete',
													'confirm' => 'Вы действительно хотите удалить фильтр перехода с задания '.$_task->name.' на задание '.( $targetTask ? $targetTask->name : '(отсутствует)').'?'
												)
											)
							),
							'css' => array(
								'edit' => 'info',
								'delete' => 'danger'
							)
						)
					);
				}
				?>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>