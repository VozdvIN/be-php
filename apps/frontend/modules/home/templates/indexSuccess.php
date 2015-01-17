<div>
	<?php if (!$_userAuthenticated): ?>
	<div class="border-bottom">
		<p>
			Для участия Вам нужно <?php echo link_to('войти', 'auth/login')?>.
		</p>
		<p>
			Если Вы здесь впервые, то <?php echo link_to('зарегистрируйтесь', 'auth/register')?>.
		</p>
	</div>
	<?php endif; ?>
	<div style="text-align: center">
		<div style="display: inline-block; max-width: 75%">
			<article>
				<?php echo ($homeArticle = Article::byName('Шаблонные-Главная')) ? Utils::decodeBB($homeArticle->text) : 'Заполните статью \'Шаблонные-Главная\''; ?>
			</article>
		</div>
	</div>

</div>

<div class="border-top" style="width: 100%"><!--
	
 --><div style="display:inline-block; width: 50%">
		<div style="text-align: center;">
			<div style="display: inline-block; min-width: 50%">	 
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

 --><div style="display:inline-block; width: 50%">
		<div style="text-align: center;">
			<div style="display: inline-block; min-width: 50%">	 
				<?php if ($_localNews): ?>
				<h3>Новости</h3>
				<?php else: ?>
				<h3>Новости проекта&quot;<?php echo $_currentRegion->name; ?> &quot;</h3>
				<?php endif; ?>

				<?php if ($_canEditNews && $_localNews): ?>
				<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'article/edit?id='.$_localNews->id); ?></span>
				<?php endif; ?>

				<article>
					<?php echo ($_localNews) ? Utils::decodeBB($_localNews->text) : 'Создайте для этого проекта новостной канал - статью &quot;Новости&quot;-'.$_currentRegion->name; ?>
				</article>
			</div>
		</div>
	</div><!--

--></div>