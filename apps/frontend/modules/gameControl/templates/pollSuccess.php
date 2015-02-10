<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <title><?php echo $_game->name ?></title>
  </head>
  <body style="color: white;">
    <div><?php echo $_game->name ?></div>
    <div><?php echo Timing::timeToStr($_game->game_last_update) ?></div>
    <div><?php echo $_result ?></div>
  </body>
</html>