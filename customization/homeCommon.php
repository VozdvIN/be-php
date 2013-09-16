<?php
/* Содержимое, которое в любом случае отображается на главной странице:
 * ниже homeNonAuth или homeAuth.
 * 
 * Рекомендуется, чтобы оно вкратце описывало сайт.
 */
?>
<div class="hr">
  <h1><?php echo SystemSettings::getInstance()->site_name ?></h1>
</div>
<div class="hr">
  <?php
  if ($homeArticle = Article::byName('Шаблонные-Главная'))
  {
    echo Utils::decodeBB($homeArticle->text);
  }
  ?>
</div>