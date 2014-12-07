<h2>Команды</h2>

<?php if ($sf_user->isAuthenticated()): ?>
<p>
	<span class="info info-bg pad-box box"><?php echo link_to('Написать статью', 'article/new') ?></span>
</p>
<?php endif ?>

<?php if ($_articles->count() == 0): ?>
<p class="info">
	Пока что не написано ни одной статьи.
</p>
<?php else: ?>
<table class="no-border">
	<tbody>
		<?php foreach ($_articles as $article): ?>
		<tr>
			<td><?php echo link_to($article->name, 'article/show?id='.$article->id); ?></td>
			<td><?php echo ($article->web_user_id == $_sessionWebUserId) ? 'Ваша статья' : '&nbsp;'?></td>
			<td>
				<?php
				if ($article->path !== "")
				{
					foreach (get_path_to_article($article->getRawValue()) as $link)
					{
						echo '\\'.$link;
					}
				}
				else
				{
					echo '&nbsp;';
				};
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>