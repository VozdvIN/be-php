<table>
	<thead>
		<tr>
			<th>Место</th>
			<th>Команда</th>
			<th>Очки</th>
			<th>Время</th>
		</tr>
	</thead>
	<tbody>
		<?php $place = 1 ?>
		<?php foreach ($_results as $teamResult): ?>
		<tr>
			<td style="text-align: center"><?php echo $place ?></td>
			<td><?php echo DCTools::recordById($_teams->getRawValue(), $teamResult['id'])->name ?></td>
			<td style="text-align: center"><?php echo $teamResult['points'] ?></td>
			<td><?php echo Timing::intervalToStr($teamResult['time']) ?></td>
		</tr>
		<?php $place++ ?>
		<?php endforeach; ?>
	</tbody>
</table>
