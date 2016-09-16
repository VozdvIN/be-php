<h3><?php echo $_article->name ?></h3>

<p>
	<?php echo '&copy;&nbsp;'.$_article->getAuthorNameSafe().', '.Timing::dateToStr($_article->created_at); ?>
</p>
<?php if ($_isModer): ?>
<p>
	<?php echo 'Id:&nbsp;'.$_article->id; ?>
</p>
<?php endif; ?>

<?php if ($_canEdit): ?>
<p>
	<span class="button-info"><?php echo link_to('Редактировать статью', 'article/edit?id='.$_article->id) ?></span>
	<span class="button-danger"><?php echo link_to('Удалить статью', 'article/delete?id='.$_article->id, array('method' => 'post', 'confirm' => 'Вы уверены, что хотите удалить статью?')) ?></span>
</p>
<?php endif; ?>

<article>
	<?php echo Utils::decodeBB($_article->text); ?>
</article>