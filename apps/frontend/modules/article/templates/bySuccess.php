<h2>404 ...Not found</h2>
<h3>Статья &quot;<?php echo $_articleName ?>&quot;</h3>
<p>
	Извините, но такую статью найти не удалось.
</p>
<p>
	Вы можете попробовать найти ее вручную в <?php echo link_to('общем списке статей', 'article/index') ?>.
</p>

<?php if ($_children->count() > 0):?>
<h3>Ссылающиеся статьи</h3>
<p>
	Ниже приведен список статей, для которых статья &quot;<?php echo $_articleName ?>&quot; указана как родительская:
</p>
<ul>
<?php	foreach ($_children as $article): ?>
	<li><?php echo link_to_article($article->getRawValue()) ?></li>
<?php	endforeach ?>
</ul>
<?php endif ?>
