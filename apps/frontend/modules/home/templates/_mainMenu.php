<?php
$sessionWebUser = $sf_user->isAuthenticated() ? $sf_user->getSessionWebUser()->getRawValue() : false;
$showModeration = $sessionWebUser && $sessionWebUser->hasSomeToModerate();
?>

<div class="pad-bottom" style="min-height: 50px"><!--
 --><div style="display: inline-block;">
		<a href="/home/index" style="display: inline-block">
			<img src="/images/logo.png" alt="<?php echo SiteSettings::SITE_NAME ?>" />
		</a>
	</div><!--
 --><div style="display: inline-block; padding-left: 6px;">
		<article>
			<?php echo ($footerArticle = Article::byName('Шаблонные-Шапка')) ? Utils::decodeBB($footerArticle->text) : '(Заполните статью \'Шаблонные-Шапка\')'; ?>
		</article>
	</div><!--
 --><div>
		<?php
			$items = array();

			if ( ! $sf_user->isAuthenticated())
			{
				$items = array(
					'Вход' => 'auth/login',
					'Регистрация' => 'auth/register'
				);
			}
			else
			{
				$items = array(
					Region::byId($sf_user->getAttribute('region_id'))->name => '/home/index',
					'Профиль' => 'webUser/show?id='.$sf_user->getAttribute('id'),
					'Команды' => 'team/index',
					'Игры' => 'game/index',
					'Участники' => 'webUser/index',
					'Статьи' => 'article/by?name=Разделы'
				);

				if ($showModeration)
				{
					$items = array_merge($items, array('Модерирование' =>'moderation/show'));
				};

				$items = array_merge($items, array('Выход' => 'auth/logout'));
			}

			include_partial('global/menu', array('activeItem' => '', 'items' => $items, 'useHeader' => true));
		?>
	</div>
</div>