<?php
include_partial('menu', array('_activeItem' => 'Задание', '_teamState' => $teamState));
$retUrlRaw = Utils::encodeSafeUrl(url_for('play/task?id='.$_teamState->id));
?>

<p class="info">
	Ваша команда может выбрать себе следующее задание:
</p>

<ul>
	<?php foreach ($availableTasksManual as $task): ?>
	<li>
		<?php if ($isLeader): ?>
		<span class="safeAction"><?php echo link_to($task->public_name, 'gameControl/setNext?teamState='.$teamState->id.'&taskId='.$task->id.'&returl='.$retUrlRaw, array('method' => 'post', 'confirm' => 'Вы уверены, что хотите приступить к выполнению задания "'.$task->public_name.'"?')) ?></span>
		<?php else: ?>
		<?php echo $task->public_name ?>
	<?php endif ?>
	</li>
	<?php endforeach ?>
</ul>

<?php if ( ! $isLeader): ?>
<p class="info">
	Выбрать следующее задание может только капитан команды.
</p>
<?php endif ?>

<p>
	Время ожидания не влияет на доступное игровое время.
</p>