<?php
/* Входные данные:
 * - $_team - команда
 * - $_activeItem - название активной вкладки
 */
?>

<?php
	include_partial('global/menu', array(
		'activeItem' => $_activeItem,
		'items' => array(
			'Экипаж' => 'team/showCrewIndex?id='.$_team->id,
			'Заявки' => 'team/showCrewJoins?id='.$_team->id
		)
	));
?>