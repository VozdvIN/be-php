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
	</head>
	<body onload="startTime()"><!--
	 --><section>
			<?php include_partial('global/flashes'); ?>
		</section><!--
	 --><section>
			<?php echo $sf_content; ?>
		</section>
	</body>
</html>