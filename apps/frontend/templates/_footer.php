<div class="border-top">
	<div style="display: inline-block; width: 50%">
		<div style="text-align: left;">
			<div style="display: inline-block;">
				<?php if ($sf_user->isAuthenticated()): ?>
				<p>
					Текущий проект: <?php echo Region::byId($sf_user->getAttribute('region_id'))->name ?>
				</p>
				<?php endif; ?>
				<p>
					Время сервера: <span id="serverTime">--:--:--</span>.
				</p>
			</div>
		</div>
	</div><!--

	 --><div style="display: inline-block; width: 50%">
		<div style="text-align: right;">
			<div style="display: inline-block;">	
				<article>
					<?php echo ($footerArticle = Article::byName('Шаблонные-Подвал')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Подвал\')'; ?>  
				</article>
				<p class="border-top">
					Powered by <a href="http://beavengine.ru" target="_blank">Beaver's Engine</a>.
				</p>
			</div>
		</div>
	</div>
</div>