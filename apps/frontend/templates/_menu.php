<?php
/* Входные аргументы:
 * array   $items      список позиций меню, ключ = название, значение = ссылка
 * string  $activeItem название активного элемента
 * string  $headerItem этот элемент меню отображать как заголовок
 * string  $backUrl    ссылка для кнопки возврата, кнопка не показана, если сылка пуста
 */
?>
<nav class="menu">
	<ul><!--
		<?php if ($backUrl):?>
			--><li><a href="<?php echo url_for($backUrl); ?>">&lt;&lt;</a></li><!--
		<?php endif; ?>
		<?php foreach ($items->getRawValue() as $title => $addr): ?>
		<?php
			$class = '';
			if ($title === $headerItem)
			{
				$class = 'header';
			}
			else if ($title === $activeItem)
			{
				$class = 'active';
			}
		?>
		--><li><a class="<?php echo $class; ?>" href="<?php echo url_for($addr); ?>"><?php echo $title ?></a></li><!--
		<?php endforeach; ?>
 --></ul>
</nav>
