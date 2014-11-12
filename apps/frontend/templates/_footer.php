<div class="hr" style="width:100%;"> 
    <div style="width:30%; display:inline-block; font-size: smaller">
        Время сервера: <span id="serverTime">--:--:--</span>.
    </div><div style="width:40%; display:inline-block;">
        &nbsp;
    </div><div style="width:30%; display:inline-block; font-style: italic; font-size: smaller">
        <?php echo ($footerArticle = Article::byName('Шаблонные-Подвал')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Подвал\')'; ?>    
    </div>
</div>

<div style="font-size: smaller; text-align: right; margin-top: 0.5em">
    Powered by <a href="http://beavengine.ru" target="_blank">Beaver's Engine</a>.
</div>