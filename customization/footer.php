<div class="hr"></div>
<div style="width:100%; border: none; padding: 0 0 0 0; margin: 0 0 0 0"> 

  <div style="width:30%; display:inline-block; font-size: smaller">
    Время сервера: <span id="serverTime">--:--:--</span>.
  </div><div style="width:40%; display:inline-block;">
	&nbsp;
  </div><div style="width:30%; display:inline-block; font-style: italic; font-size: smaller">
    <div>
      <?php
        if ($footerArticle = Article::byName('Шаблонные-Подвал'))
        {
          echo Utils::decodeBB($footerArticle->text);
        }
        else
        {
          echo '(Заполните статью \'Шаблонные-Подвал\')';
        }
      ?>    
    </div>
  </div>
</div>

