<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Шаблоны',
			'_isModerator' => $_isModerator
		)
	);
	
	$retUrlRaw = Utils::encodeSafeUrl(url_for('game/teams?id='.$_game->id));
?>

<h3>Шаблоны</h3>