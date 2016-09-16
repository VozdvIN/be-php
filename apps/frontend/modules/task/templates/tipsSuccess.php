<?php
	include_partial('taskMenu', array('_task' => $_task, '_activeItem' => 'Подсказки'));
	$retUrlRaw = Utils::encodeSafeUrl(url_for('task/tips?id='.$_task->id));
?>

<table>
	<thead>
		<tr>
			<th>Название</th>
			<th>Выдача</th>
			<th>Формулировка</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($_tips as $tip): ?>
		<tr>
			<td>
				<?php echo $tip->name; ?>
			</td>
			<td>
				<?php
					if ($tip->answer_id > 0)
					{
						echo "после&nbsp;ответа&nbsp;'".$tip->Answer->name."'";
					}
					elseif ($tip->delay == 0)
					{
						echo 'сразу';
					}
					else
					{
						echo 'через&nbsp;'.Timing::intervalToStr($tip->delay*60);
					}
				?>
			</td>
			<td>
				<article>
					<?php echo Utils::decodeBB($tip->define); ?>
				</article>
			</td>
			<td>
				<?php if ($_isManager || $_isModerator): ?>
				<span class="button-info">
					<?php echo link_to('Править', 'tip/edit?id='.$tip->id); ?>
				</span>
				<span class="button-danger">
					<?php
						echo link_to(
							'Удалить',
							'tip/delete?id='.$tip->id.'&returl='.$retUrlRaw,
							array(
								'method' => 'delete',
								'confirm' => 'Вы действительно хотите удалить подсказку '.$tip->name.' к заданию '.$tip->Task->name.'?'
							)
						)
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
			<td colspan="4">
				<span class="button-info"><?php echo link_to('Добавить', 'tip/new?taskId='.$_task->id); ?></span>
			</td>
		</tr>
		<?php endif; ?>
	</tfoot>
</table>