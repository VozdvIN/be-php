<h2>Регистрация игрока в команду &quot;<?php echo $team->name; ?>&quot;</h2>

<p class="info">
	Если участника нет в списке, значит он подал заявку или входит в состав команды.
</p>

<?php if ($team->teamPlayers->count() == 0): ?>
<p class="warn">
	Выбранный участник будет назначен капитаном, так как в команде еще нет игроков.
</p>
<?php endif; ?>

<p>
	Выберите одного из участников:
</p>
<ul>
	<?php foreach ($webUsers as $webUser): ?>
	<li><?php echo link_to($webUser->login, 'team/setPlayer'.'?id='.$team->id.'&userId='.$webUser->id, array('method' => 'post')); ?></li>
	<?php endforeach; ?>
</ul>
