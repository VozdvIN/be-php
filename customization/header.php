<?php
/* Заголовок сайта, общий для всех страниц, кроме текущего задания.
 * 
 * Рекомендуется, чтобы он содержал логотип и название сайта.
 * 
 * Не рекомендуется использовать элементы стиля "float: right",
 * так как это может сделать непредсказуемым расположение
 * ссылок авторизации (вход/выход, регистрация),
 * находящихся в правом верхнем углу.
 */
?>

<div class="hidden">

  <!-- Yandex.Metrika counter -->
  <!-- /Yandex.Metrika counter -->

</div> <!-- end:hidden -->

<div style="min-height: 58px;">
  <div style="float: left; padding-right: 8px; padding-bottom: 0.4em;">
    <a href="/home/index" class="banner"><img src="/customization/images/logo.png" alt="<?php echo SystemSettings::getInstance()->site_name ?>" /></a>
  </div>
  <div>
    <span style="font-weight: bold"><?php echo SystemSettings::getInstance()->site_name ?></span>
  </div>  
  <div>
    <?php
      if ($headerArticle = Article::byName('Шаблонные-Шапка'))
      {
        echo Utils::decodeBB($headerArticle->text);
      }
      else
      {
        echo '(Заполните статью \'Шаблонные-Шапка\')';
      }
    ?>
  </div>
</div>