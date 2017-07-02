<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="ru">
		<link rel="stylesheet" type="text/css" href="/css/basic.css" />
		<link rel='shortcut icon' href='/images/favicon.png' />
		<?php include_title() ?>
		<?php endif; ?>
	</head>
	<body onload="startTime()">
		<?php include_partial('global/flashes'); ?>
		<?php echo $sf_content; ?>
		<div class="hr">
			<?php echo link_to('Главная', 'home/index').' '.link_to('Выйти', 'auth/logout'); ?>
		</div>
	</body>
</html>