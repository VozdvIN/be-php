<?php
/* Входные аргументы:
 * array   $items          список позиций меню, ключ = название, значение = ссылка
 * string  $activeItem    название активного элемента
 * string  $headerItem    этот элемент меню отображать как заголовок
 * array   $itemsVisible  разрешения на отображение элементов, ключ = заголовок элемента, значение = условие отображения.
 * По-умолчанию все элементы видимы.
 */
$headerItem = isset($headerItem) ? $headerItem : '';
$itemsVisible = isset($itemsVisible) ? $itemsVisible : array();
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
		<?php if ( ! isset($itemsVisible[$title]) || $itemsVisible[$title]): ?>
		--><li><a class="<?php echo $class; ?>" href="<?php echo url_for($addr); ?>"><?php echo $title ?></a></li><?php echo ($title === $headerItem) ? '<br>' : ''?><!--
		<?php endif; ?>
		<?php endforeach; ?>
 --></ul>
</nav>
