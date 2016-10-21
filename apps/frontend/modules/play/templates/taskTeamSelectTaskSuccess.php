<?php include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState)); ?>

<?php if ( ! $isLeader): ?>
<p class="info">
	Ваш капитан может выбрать для вашей команды следующее задание.
</p>
<?php else: ?>
<p>
	Вы можете выбрать для вашей команды следующее задание:
</p>
<?php endif ?>

<ul>
	<?php foreach ($availableTasksManual as $task): ?>
	<li>
		<?php if ($isLeader): ?>
		<span class="safeAction"><?php echo link_to($task->public_name, 'play/setNext?id='.$teamState->id.'&taskId='.$task->id, array('method' => 'post', 'confirm' => 'Вы уверены, что хотите приступить к выполнению задания "'.$task->public_name.'"?')) ?></span>
		<?php else: ?>
		<?php echo $task->public_name ?>
		<?php endif ?>
	</li>
	<?php endforeach ?>
</ul>

<p>
	Время ожидания не влияет на доступное игровое время.
</p>

<?php include_partial('teamFooter', array('_teamState' => $teamState)); ?>
