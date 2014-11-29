<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="ru">
		<link rel="stylesheet" type="text/css" href="/css/basic.css" />
		<link rel='shortcut icon' href='/images/favicon.png' />
		<?php include_title() ?>
		<script type="text/javascript">
			<?php render_timer_script(); ?>
		</script>
	</head>
	<body onload="startTime()">
		<header class="pad-bottom"><!--
		 --><?php include_partial('global/header'); ?><!--
	 --></header>
		
		<section>
			<?php include_partial('global/mainMenu'); ?>
		</section>
		
		<section>
			<?php include_partial('global/flashes'); ?>
		</section>
		
		<section>
			<?php echo $sf_content; ?>
		</section>
		
		<footer class="pad-top border-top"><!--
		 --><?php include_partial('global/footer'); ?><!--
	 --></footer>
	</body>
</html>