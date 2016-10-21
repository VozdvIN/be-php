<?php include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Ответы')); ?>

<table class="no-border">
	<thead>
		<?php if ($_isManager || $_isModerator): ?>
		<tr><td colspan="5"><span class="button-info"><?php echo link_to('Добавить', 'answer/new?taskId='.$_task->id); ?></span></td></tr>
		<?php endif; ?>
		<tr><th>Название</th><th>Описание</th><th>Значение</th><th>Команда</th><th>&nbsp;</th></tr>
	</thead>
	<tbody>
		<?php foreach ($_answers as $answer): ?>
		<tr>
			<td><?php echo $answer->name; ?></td>
			<td><?php echo $answer->info; ?></td>
			<td><?php echo $answer->value; ?></td>
			<td><?php echo (($answer->team_id !== null) && ($answer->team_id != 0)) ? $answer->Team->name : 'все'; ?></td>
			<td>
				<?php
				if ($_isManager || $_isModerator)
				{
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'edit' => link_to('Править', 'answer/edit?id='.$answer->id),
								'delete' => link_to(
												'Удалить',
												'answer/delete?id='.$answer->id,
												array(
													'method' => 'delete',
													'confirm' => 'Вы действительно хотите удалить ответ '.$answer->name.' задания '.$_task->name.'?'
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
