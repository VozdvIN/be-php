<?php
/**
 * Входные аргументы:
 * - Game $game - игра, для которой строится отчет.
 */
$results = $game->getGameResults();
?>
<table cellspacing="0">
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
    <?php foreach ($results as $teamResult): ?>
    <tr>
      <td><?php echo $place ?></td>
      <td><?php echo Team::byId($teamResult['id'])->name ?></td>
      <td><?php echo $teamResult['points'] ?></td>
      <td><?php echo Timing::intervalToStr($teamResult['time']) ?></td>
    </tr>
    <?php $place++ ?>
    <?php endforeach; ?>
  </tbody>
</table>
