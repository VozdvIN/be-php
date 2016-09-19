<h2>Игра &quot;<?php echo $_game->name ?>&quot;</h2>

<p>
	Выберите команду, которую вы заявляете на игру:
</p>

<ul>
<?php foreach ($_teamList as $team): ?>
	<li><?php echo link_to($team->name, 'game/postJoin'.'?id='.$_game->id.'&teamId='.$team->id, array ('method' => 'post')); ?></li>
<?php endforeach; ?>
</ul>

<p class="info">
	Показаны только те команды, от имени которых Вы можете подать заявку, и которые еще не регистрировались на игру.
</p>