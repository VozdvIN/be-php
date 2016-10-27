<?php include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Подсказки')); ?>

<table>
	<thead>
		<?php if ($_isManager || $_isModerator): ?>
		<tr><td colspan="4"><span class="button-info"><?php echo link_to('Добавить', 'tip/new?taskId='.$_task->id); ?></span></td></tr>
		<?php endif; ?>
		<tr><th>Название</th><th>Выдача</th><th>Формулировка</th><th>&nbsp;</th>/tr>
	</thead>
	<tbody>
		<?php foreach ($_tips as $tip): ?>
		<tr>
			<td>
				<?php echo $tip->name; ?>
			</td>
			<td>
				<?php
					if ($tip->answer_id > 0) echo "после&nbsp;ответа&nbsp;'".$tip->Answer->name."'";
					elseif ($tip->delay == 0) echo 'сразу';
					else echo 'через&nbsp;'.Timing::intervalToStr($tip->delay*60);
				?>
			</td>
			<td>
				<article>
					<?php echo Utils::decodeBB($tip->define); ?>
				</article>
			</td>
			<td>
				<?php
				if ($_isManager || $_isModerator)
				{
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'edit' => link_to('Править', 'tip/edit?id='.$tip->id),
								'delete' => link_to(
												'Удалить',
												'tip/delete?id='.$tip->id,
												array(
													'method' => 'delete',
													'confirm' => 'Вы действительно хотите удалить подсказку '.$tip->name.' к заданию '.$tip->Task->name.'?'
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