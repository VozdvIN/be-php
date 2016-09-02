<?php
/* Входные аргументы:
 * array   $items      список позиций меню, ключ = название, значение = ссылка
 * string  $activeItem название активного элемента
 * string  $useHeader  первый элемент меню отображать как заголовок
 * string  $backUrl    ссылка для кнопки возврата, кнопка не показана, если сылка пуста
 */
?>
<nav class="menu">
	<ul><!--
		<?php if ($backUrl):?>
			--><li><a href="<?php echo url_for($backUrl); ?>">&lt;&lt;</a></li><!--
		<?php endif; ?>
		<?php
			$firstItem = true;
		?>
		<?php foreach ($items->getRawValue() as $title => $addr): ?>
		<?php
			$class = '';
			if ($title === $activeItem)
			{
				$class = 'active';
			}
			else if ($firstItem && $useHeader)
			{
				$class = 'header';
			}
		?>
		--><li><a class="<?php echo $class; ?> ?>" href="<?php echo url_for($addr); ?>"><?php echo $title ?></a></li><!--
		<?php $firstItem = false; ?>
		<?php endforeach; ?>
 --></ul>
</nav>
