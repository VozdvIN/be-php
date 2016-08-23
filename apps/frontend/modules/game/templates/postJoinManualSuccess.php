<h2>Подача командной заявки на игру &quot;<?php echo $game->name ?>&quot;</h2>

<p class="info">
	Показаны только те команды, от имени которых Вы можете подать заявку, и которые еще не регистрировались на игру.
</p>
<p>
	Выберите одну из команд (нажмите на ссылку):
</p>

<ul>
<?php foreach ($teamList as $team): ?>
	<li>
		<?php echo link_to($team->name, 'game/postJoin'.'?id='.$game->id.'&teamId='.$team->id.'&returl='.$retUrl, array ('method' => 'post')); ?>
	</li>
<?php endforeach; ?>
</ul>