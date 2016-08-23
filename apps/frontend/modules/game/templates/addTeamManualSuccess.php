<h2>Регистрация команды на игру &quot;<?php echo $game->name ?>&quot;</h2>

<p class="info">
	Если команды нет в списке, значит она уже заявилась или зарегистрирована на эту игру.
</p>
<p>
	Выберите одну из команд (нажмите на ссылку):
</p>
<ul>
	<?php foreach ($teamList as $team): ?>
	<li>
		<?php echo link_to($team->name, 'game/addTeam'.'?id='.$game->id.'&teamId='.$team->id.'&returl='.$retUrl,array ('method' => 'post')); ?>
	</li>
	<?php endforeach; ?>
</ul>