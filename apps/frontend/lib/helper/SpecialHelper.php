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

/**
 * Генерирует код одного поля формы с разметкой, аналогичной списку свойств.
 *
 * @param   sfFormField   $field  поле для отображения
 *
 * @return  string
 */
function render_form_field(sfFormField $field)
{
	if ( ! $field->isHidden())
	{
		echo '<tr>';
		
		// Метка поля
		echo '<td>';
		echo $field->renderLabel();
		echo '</td>';
		
		// Само поле
		echo '<td>';
		echo $field->render();
		echo '</td>';
		
		// Комментарии к полю (и ошибки)
		echo '<td>';		
		if ($field->hasError())
		{
			echo '<div><span class="danger">'.$field->getError().'</span></div>';
		}
		
		$helps = explode('|', $field->getParent()->getWidget()->getHelp($field->getName()));
		foreach ($helps as $help)
		{
			echo '<div><span>'.$help.'</span></div>';
		}
		echo '</td>';
		
		echo '</tr>';
	}
	else
	{
		echo $field->render();
	}
}

/**
 * Генерирует код для отправки формы с разметкой, аналогичной списку свойств.
 *
 * @param   sfForm    $form         форма для отображения
 * @param   string    $commitLabel  название кнопки отправки формы
 */
function render_form_commit(sfForm $form, $commitLabel)
{
	echo '<tr>';
	echo '<td colspan="3">';
	
	// Способ отправки
	if ( ($form instanceof sfDoctrineForm) && ( ! $form->getObject()->isNew()))
	{
		echo '<input type="hidden" name="sf_method" value="put" />';
	}
	// Защитный токен
	$form['_csrf_token']->render();
	
	// Кнопка отправки
	echo '<input type="submit" value="'.$commitLabel.'" />';
	echo '</td>';
	echo '</tr>';
}

/**
 * Генерирует код формы (без заголовка) с разметкой, аналогичной списку свойств.
 *
 * @param   sfForm    $form         форма для отображения
 * @param   string    $commitLabel  название кнопки отправки формы
 * @param   string    $backHtml     html-код обратного перехода при отказе от отправки.
 */
function render_form(sfForm $form, $commitLabel, $backHtml)
{
	// Тэг открытия формы уже находится в выводе, поэтому сейчас создаем только разметку полей
	echo '<table class="no-border">';
	
	echo '<tbody>';
	foreach($form as $field)
	{
		render_form_field($field);
	}
	echo '</tbody>';
	
	echo '<tfoot>';
	render_form_commit($form, $commitLabel, $backHtml);
	echo '</tfoot>';
	
	echo '<table>';
}

/**
 * Генерирует код скрипта для отображения текущего времени
 * @param   string    $value  значение
 * @param   integer   $width  ширина в ex
 * @param   string    $align  выравнивание text-align
 */
function render_timer_script()
{
  //TODO: Вынести в шаблон
  $decodedTime = localtime(Timing::getActualTime(), true);
  $s = $decodedTime['tm_sec'];
  $m = $decodedTime['tm_min'];
  $h = $decodedTime['tm_hour'];
  echo 'var h = '.$h.';';
  echo 'var m = '.$m.';';
  echo 'var s = '.$s.';';
  echo 'function startTime() {';
  echo '  s = s + 1;';
  echo '  if (s >= 59) {';
  echo '    s = 0;';
  echo '    m = m + 1;';
  echo '    if (m >= 59) {';
  echo '      m = 0;';
  echo '      h = h + 1;';
  echo '      if (h >= 23) {';
  echo '        h = 0;';
  echo '      }';
  echo '    }';
  echo '  }';
  echo '  document.getElementById("serverTime").innerHTML = ((h>9) ? h : "0"+h) + ":" + ((m>9) ? m : "0"+m) + ":" + ((s>9)? s : "0"+s);';
  echo '  html = setTimeout("startTime()",999);';
  echo '}';
}
?>