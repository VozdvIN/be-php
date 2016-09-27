<h2>Игровые проекты</h2>

<table class="no-border">
	<thead><tr><td colspan="2"><span class="button-info"><?php echo link_to('Создать проект', 'region/new'); ?></span></td></tr></thead>
	<tbody>
		<?php foreach ($_regions as $region): ?>
		<tr>
			<td><?php echo $region->name ?></td>
			<td>
				<span class="button-warn"><?php echo link_to('Править', 'region/edit?id='.$region->id) ?></span>
				<?php if ($region->id != Region::DEFAULT_REGION): ?>
				<span class="button-danger"><?php echo link_to('Удалить', 'region/delete?id='.$region->id, array('method' => 'delete', 'confirm' => 'Вы правда хотите удалить игровой проект '.$region->name.' ?')) ?></span>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
