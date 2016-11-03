<?php

/**
 * Генерирует код оформления числа в зависимости от его знака
 *
 * @param   integer   $value  исходное число
 *
 * @return  string
 */
function decorate_number($value)
{
	if ($value == 0)
	{
		return '<span>&nbsp;'.$value.'</span>';
	}
	return ($value >= 0)
		? '<span class="info">+'.$value.'</span>'
		: '<span class="info">-'.(-$value).'</span>';
}

/**
 * Возвращает HTML-код, обрамляющий указанный, для выделения соответствующим span-классом.
 *
 * @param   string   $class       CSS-класс тега span
 * @param   string   $innerHtml   HTML-код для обрамления
 *
 * @return  string
 */
function decorate_span($class, $innerHtml)
{
  return '<span class="'.$class.'">'.$innerHtml.'</span>';
}

?>