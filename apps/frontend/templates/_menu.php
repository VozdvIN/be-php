<?php
/* Входные аргументы:
 * array   $items      список позиций меню, ключ = название, значение = ссылка
 * string  $activeItem название активного элемента
 * string  $headerItem этот элемент меню отображать как заголовок
 */
?>
<nav class="menu">
	<ul><!--
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
