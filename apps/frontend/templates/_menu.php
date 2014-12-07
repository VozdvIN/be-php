<?php
/* Входные аргументы:
 * array   $items      список позиций меню, ключ = название, значение = ссылка
 * string  $activeItem название активного элемента
 */
?>
<nav class="menu pad-top pad-bottom">
	<ul><!--
		<?php foreach ($items->getRawValue() as $title => $addr): ?>
		--><li><a <?php echo $title === $activeItem ? 'class="active"' : ''; ?> href="<?php echo url_for($addr); ?>"><?php echo $title ?></a></li><!--
		<?php endforeach; ?>
 --></ul>
</nav>
