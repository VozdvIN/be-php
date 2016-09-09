<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="content-language" content="ru">
		<link rel="stylesheet" type="text/css" href="/css/basic.css" />
		<link rel='shortcut icon' href='/images/favicon.png' />
		<?php include_title() ?>
		<script type="text/javascript">
			<?php render_timer_script(); ?>
		</script>
		<?php if (Utils::LOAD_TEST_MODE): ?>
		<script type="text/javascript">
			setTimeout(function() { window.location.reload(true); }, Math.round(30000 + 60000 * Math.random()));
		</script>
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