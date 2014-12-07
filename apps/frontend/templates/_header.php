<div style="display: inline-block; width: 16%">
	<div style="text-align: left;">
		<div style="display: inline-block;">	
			<a href="/home/index">
				<img src="/images/logo.png" alt="<?php echo SiteSettings::SITE_NAME ?>" />
			</a>
			<div class="hidden">
				<!-- Yandex.Metrika counter -->
				<!-- /Yandex.Metrika counter -->
			</div>
		</div>
	</div>
</div><!--
	   
 --><div style="display: inline-block; width: 54%">
	<div style="text-align: center;">
		<div style="display: inline-block;">
			<h1 style="text-align: center; padding: 0 0 0 0;"><?php echo SiteSettings::SITE_NAME ?></h1>
			<article>
				<?php echo ($headerArticle = Article::byName('Шаблонные-Шапка')) ? Utils::decodeBB($headerArticle->text) : '(Заполните статью \'Шаблонные-Шапка\')'; ?>
			</article>
		</div>
	</div>
 </div><!--
 
 --><div style="display: inline-block; width: 30%">
	<div style="text-align: right;">
		<div style="display: inline-block;">
			<p>
				<?php
				if ($sf_user->isAuthenticated())
				{
					$backLinkEncoded = Utils::encodeSafeUrl($_SERVER['REQUEST_URI']);
					echo '(';
					echo link_to($sf_user->getAttribute('login'), 'webUser/show?id='.$sf_user->getAttribute('id'));
					echo ' @&nbsp;';
					echo link_to(Region::byId($sf_user->getAttribute('region_id'))->name, 'region/setCurrent?returl='.$backLinkEncoded);
					echo ') '.link_to('Выйти', 'auth/logout');
				}
				else
				{
					echo link_to('Зарегистрироваться', 'auth/register');
					echo ' '.link_to('Войти', 'auth/login');
				}
				?>
			<p>
		</div>
	</div>
 </div>