<div class="logo">
	<a href="/home/index" class="banner">
		<img src="/images/logo.png" alt="<?php echo SystemSettings::getInstance()->site_name ?>" />
	</a>
    <div class="hidden">
        <!-- Yandex.Metrika counter -->
        <!-- /Yandex.Metrika counter -->
    </div>
</div><!--
	   
 --><div class="title">
	<p>
		<span style="font-weight: bold"><?php echo SystemSettings::getInstance()->site_name ?></span>
	</p>
	<article>
		<?php echo ($headerArticle = Article::byName('Шаблонные-Шапка')) ? Utils::decodeBB($headerArticle->text) : '(Заполните статью \'Шаблонные-Шапка\')'; ?>
	</article>
 </div><!--
 
 --><div class="login">
	 <p>
		<?php
		if ($sf_user->isAuthenticated())
		{
			$backLinkEncoded = Utils::encodeSafeUrl($_SERVER['REQUEST_URI']);
			echo '(';
			echo link_to($sf_user->getAttribute('login'), 'webUser/show?id='.$sf_user->getAttribute('id'));
			echo '&nbsp;@&nbsp;';
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