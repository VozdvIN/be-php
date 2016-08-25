<div class="border-top">
	<div style="display: inline-block; width: 30%"><!--
	 --><p>
			Время сервера: <span id="serverTime">--:--:--</span>.
		</p>
		<p class="pad-top">
			Powered by <a href="http://beavengine.ru" target="_blank">Beaver's Engine</a>.
		</p>
	</div><!--
 --><div style="display: inline-block; width: 70%">
		<article>
			<?php echo ($footerArticle = Article::byName('Шаблонные-Подвал')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Подвал\')'; ?>  
		</article>
	</div>
</div>