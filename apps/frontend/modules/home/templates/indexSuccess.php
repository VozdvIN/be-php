<?php
	include_partial('mainMenu');
?>

<div><!--
 --><div style="display: inline-block;">
		<a href="/home/index" style="display: inline-block">
			<img src="/images/logo.png" alt="<?php echo SiteSettings::SITE_NAME ?>" />
		</a>
	</div><!--
 --><div style="display: inline-block;">
		<article>
			<?php echo ($footerArticle = Article::byName('Шаблонные-Шапка')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Шапка\')'; ?>
		</article>
	</div>
</div>

<div style="width: 100%"><!--
 --><div style="display:inline-block; width: 50%">
		<div style="text-align: right; margin-right: 6px;">
			<article>
				<?php echo ($homeArticle = Article::byName('Шаблонные-Главная')) ? Utils::decodeBB($homeArticle->text) : 'Заполните статью \'Шаблонные-Главная\''; ?>
			</article>
		</div>
	</div><!--

 --><div style="display:inline-block; width: 50%">
		<div style="text-align: left; margin-left: 6px;">
			<div style="display: inline-block">
				<h3>Анонсы</h3>
				<?php if ($_games->count() > 0): ?>
					<?php
					foreach ($_games as $game)
					{
						include_partial('gameAnnounce', array('game' => $game, '_isAuth' => $_userAuthenticated));
					}
					?>
				<?php else: ?>
				<p>
					В ближайшее время игр не планируется.
				</p>
				<?php endif; ?>
			</div>
		</div>
	</div><!--

--></div>

<div class="border-top">
	<div style="display: inline-block; width: 30%"><!--
	 --><p>
			Время сервера: <span id="serverTime">--:--:--</span>.
		</p>
		<p>
			Powered by <a href="http://beavengine.ru" target="_blank">Beaver's Engine</a>.
		</p>
	</div><!--
 --><div style="display: inline-block; width: 70%">
		<article>
			<?php echo ($footerArticle = Article::byName('Шаблонные-Подвал')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Подвал\')'; ?>
		</article>
	</div>
</div>