<div class="banners">
	<p>
		Время сервера: <span id="serverTime">--:--:--</span>.
	</p>
</div><!--

--><div class="credits">
	<article>
		<?php echo ($footerArticle = Article::byName('Шаблонные-Подвал')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Подвал\')'; ?>  
	</article>
	<p>
		Powered by <a href="http://beavengine.ru" target="_blank">Beaver's Engine</a>.
	</p>
</div>