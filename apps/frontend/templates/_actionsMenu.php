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
/*
<?php
include_partial(
	'global/actionsMenu',
	array(
		'items' => array(
			'edit' => link_to('', ''),
			'delete' => link_to('', '')
		),
		'css' => array(
			'edit' => 'info',
			'delete' => 'danger'
		),
		'conditions' => array(
			'edit' => 'info',
			'delete' => 'danger'
		)
	)
);
?>
*/
?>

<div style="text-align: left"><!--
	<?php foreach ($items->getRawValue() as $title => $html): ?>
	<?php
		$classStr = 'class="button';
		$class = isset($css[$title]) ? $css[$title] : '';
		$classStr = 'class="button'.(($class !== '') ? '-'.$class : '').'"';
	?>
	<?php if (( ! isset($conditions[$title])) || $conditions[$title]): ?>
 --><span <?php echo $classStr ?>><?php echo $html; ?></span><!--
	<?php endif; ?>
	<?php endforeach; ?>
--></div>
