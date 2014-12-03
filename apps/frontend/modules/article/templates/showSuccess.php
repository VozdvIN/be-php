<?php
	$path = get_path_to_article($_article->getRawValue());
	if ( ! $path)
	{
		render_breadcombs(array(link_to('Статьи', 'article/index'), $_article->name));
	}
	else
	{
		$links = array();
		$links = array_merge($links, array(link_to('Статьи', 'article/index')));
		$links = array_merge($links, $path);
		$links = array_merge($links, array($_article->name));
		render_breadcombs($links);
	}  
?>

 
<h3><?php echo $_article->name ?></h3>
<div style="text-align: right;">
	<div style="display: inline-block;">
		<p>
			<?php echo '&copy;&nbsp;'.$_article->getAuthorNameSafe().', '.Timing::dateToStr($_article->created_at); ?>
		</p>
		<?php if ($_isModer): ?>
		<p>
			<?php echo 'Id:&nbsp;'.$_article->id; ?>
		</p>
		<?php endif; ?>
	</div>
</div>

<?php if ($_canEdit): ?>
<p>
  <span class="info info-bg pad-box box"><?php echo link_to('Редактировать статью', 'article/edit?id='.$_article->id) ?></span>
  <span class="warn warn-bg pad-box box"><?php echo link_to('Удалить статью', 'article/delete?id='.$_article->id, array('method' => 'post', 'confirm' => 'Вы уверены, что хотите удалить статью?')) ?></span>
</p>
<?php endif; ?>

<article>
	<?php echo Utils::decodeBB($_article->text); ?>
</article>