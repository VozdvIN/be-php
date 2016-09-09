<?php
/* Входные аргументы:
 * array<string => string> $items       список позиций меню, ключ = название, значение = готовый HTML
 * array<string => string> $css         классы для раскраски, ключ = название, значение = класс
 * array<string => bool>   $conditions  условия отображения меню, ключ = название, значение = условие отображения
 */
	if ( ! $conditions)
	{
		$conditions = array();
	}

	if ( ! $css)
	{
		$css = array();
	}
?>

<div style="text-align: left">
	<?php foreach ($items->getRawValue() as $title => $html): ?>
	<?php
		$classStr = 'class="pad-box box';
		$class = isset($css[$title]) ? $css[$title] : '';
		if ($class !== '')
		{
			$classStr .= ' '.$class.' '.$class.'-bg';
		}
		$classStr .= '"';
	?>
	<?php if (( ! isset($conditions[$title])) || $conditions[$title]): ?>
	<span <?php echo $classStr ?>><?php echo $html; ?></span>
	<?php endif; ?>
	<?php endforeach; ?>
</div>