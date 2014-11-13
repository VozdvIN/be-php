<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/images/favicon.png" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
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
      <?php echo link_to('Главная', 'home/index').', '.link_to('Выйти', 'auth/logout'); ?>
    </div>
  </body>
</html>