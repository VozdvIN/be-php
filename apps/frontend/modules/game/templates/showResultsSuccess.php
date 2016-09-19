<?php include_partial('menu', array('_game' => $_game, '_activeItem' => 'Итоги', '_editable' => $_canManage)) ?>

<?php include_partial('resultsMenu', array('_game' => $_game, '_activeItem' => 'Места')) ?>

<table>
	<thead>
		<tr><th>Место</th><th>Команда</th><th>Очки</th><th>Время</th></tr>
	</thead>
	<tbody>
		<?php $place = 1 ?>
		<?php foreach ($_results as $teamResultInfo): ?>
		<tr>
			<td style="text-align: center"><?php echo $place++ ?></td>
			<td><?php echo $teamResultInfo['teamState']->Team->getNormalName(); ?></td>
			<td style="text-align: center"><?php echo $teamResultInfo['points'] ?></td>
			<td><?php echo Timing::intervalToStr($teamResultInfo['time']) ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>