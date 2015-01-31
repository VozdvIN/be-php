<?php

/**
 * Возвращает ссылку, по которой можно перейти к указанной статье.
 *
 * @param   Article   $article  Статья
 * 
 * @return  string;
 */
function link_to_article(Article $article)
{
  return link_to($article->name, 'article/show?id='.$article->id);
}

/**
 * Оформляет ссылку на статью, заданную именем.
 *
 * @param   string   $articleName  Статья
 * 
 * @return  string;
 */
function link_to_article_name($articleName)
{
  return link_to($articleName, 'article/by?name='.$articleName);
}

/**
 * Возвращает мыссив ссылок на статьи, согласно пути указанной статьи.
 * 
 * @param   Article   $article  Статья
 * 
 * @return  array<string>   Список ссылок (HTML-код) или False, если путь не указан.
 */
function get_path_to_article(Article $article)
{
  if ($article->path === "" || $article->path === null)
  {
    return false;
  }
  $pathNames = explode('\\', $article->path);
  $result = array();
  foreach ($pathNames as $pathName)
  {
    array_push($result, link_to_article_name($pathName));
  }
  return $result;
}

/**
 * Рассчитывает ширину блока (в ex) для размещения текста указанной длины.
 *
 * @param   mixed   $value  (Число) - длина строки, (Строка) - как есть.
 *
 * @return  integer         ширина блока в единицах ex
 * 
 * @deprecated since version 0.16.4
 */
function get_text_block_size_ex($value)
{
  $length = (is_string($value)) ? strlen($value) : $value;
  //Делитель не больше 1.5!
  return (1 + round($length / 1.6)); //Как точно считать - не ясно, пусть так будет.
}

/**
 * Возвращает длину самой длинной строки из указанного массива.
 * При каких-либо проблемах вернет 0.
 *
 * @param   array   $array  массив со строками
 *
 * @return  integer
 * 
 * @deprecated since version 0.16.4
 */
function get_max_strlen($array)
{
  if (is_array($array))
  {
    $res = 0;
    foreach ($array as $value)
    {
      if (is_string($value) && ($res < strlen($value)))
      {
        $res = strlen($value);
      }
    }
    return $res;
  }
  else
  {
    return 0;
  }
}

/**
 * Возвращает длину самого длинного значения из указанного поля коллекции.
 * При каких-либо проблемах вернет 0.
 *
 * @param   Doctrine_Collection   $collection   коллекция
 * @param   string                $fieldName    имя поля
 *
 * @return  integer
 * 
 * @deprecated since version 0.16.4
 */
function get_max_field_length(Doctrine_Collection $collection, $fieldName)
{
  if ($collection instanceof Doctrine_Collection)
  {
    $res = 0;
    foreach ($collection as $item)
    {
      if ($res < strlen($item->$fieldName))
      {
        $res = strlen($item->$fieldName);
      }
    }
    return $res;
  }
  else
  {
    return 0;
  }
}

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
		return decorate_span('', '&nbsp;'.$value);
	}
	return ($value >= 0)
		? decorate_span('info', '+'.$value)
		: decorate_span('warn', '-'.(-$value));
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
 * Возвращает HTML-код, обрамляющий указанный, для выделения соответствующим div-классом.
 *
 * @param   string   $class       CSS-класс тега span
 * @param   string   $innerHtml   HTML-код для обрамления
 *
 * @return  string
 * 
 * @deprecated since version 0.16.4
 */
function decorate_div($class, $innerHtml)
{
	return ($class !== '')
		? '<div class="'.$class.'">'.$innerHtml.'</div>'
		: '<div>'.$innerHtml.'</div>';
}

/**
 * Генерирует в поток вывода HTML-код одной строки с заголовком и несколькими значениями.
 * 
 * @param   string  $nameWidth  ширина колонки названия свойства (в единицах ex)
 * @param   string  $name       заголовок строки
 * @param   mixed   $value      значение строкой или значения массивом
 * 
 * @deprecated since version 0.16.4
 */
function render_named_line($nameWidth, $name, $values)
{
  $useValues = (is_array($values)) ? $values : array($values);
  
  echo "\n".'<div class="namedLineBox">'."\n";

  /* Финт ушами:
   * Конструкция style="width: 100%; max-width: ?" позволяет элементу
   * сжиматься менее max-width если max-width шире экрана,
   * в тоже время при достатке места он не будет шире max-width;
   */
  echo '<div class="namedLineName"'.(($nameWidth > 0) ? ' style="width: 100%; max-width:'.$nameWidth.'ex"' : '').'>';
  echo $name;
  echo '</div>';
  
  foreach ($useValues as $value)
  {
    echo '<div class="namedLineValue">';
    echo $value;
    echo '</div>';
  }
  
  echo "\n".'</div>'."\n";
}

/**
 * Генерирует в поток вывода HTML-код одной строки с заголовком и несколькими значениями,
 * но только в том случае, если выполнено условие.
 * 
 * @param   string          $nameWidth  ширина колонки названия свойства (в единицах ex)
 * @param   string          $name       заголовок строки
 * @param   array<string>   $value      значения
 * 
 * @deprecated since version 0.16.4
 */
function render_named_line_if($condition, $nameWidth, $name, $values)
{
  if ($condition)
  {
    render_named_line($nameWidth, $name, $values);
  } 
}

/**
 * Генерирует в поток вывода HTML-код начала заколовка h3 с встроенными ссылками.
 *
 * @param   string   $headerText  текст заголовка
 *
 * @return  string
 * 
 * @deprecated since version 0.16.4
 */
function render_h3_inline_begin($headerText)
{
  //Общий контейнер
  echo '<div class="h3inline">'."\n";
  //Заголовок
  echo '<h3 class="inline">'.$headerText.'</h3>';
}

/**
 * Генерирует в поток вывода HTML-код завершения заколовка h3 с встроенными ссылками.
 *
 * @return  string
 * 
 * @deprecated since version 0.16.4
 */
function render_h3_inline_end()
{
  echo '</div>'."\n";
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
			echo decorate_div('danger', $field->getError());
		}
		
		$helps = explode('|', $field->getParent()->getWidget()->getHelp($field->getName()));
		foreach ($helps as $help)
		{
			echo decorate_div('', $help);
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
 * Генерирует код заголовка столбца
 *
 * @param   string    $columnName   заголовок
 * @param   integer   $width        ширина в ex
 * 
 * @deprecated since version 0.16.4
 */
function render_column_name($columnName, $width = 0)
{
  echo '<div class="columnName"'.(($width > 0) ? ' style="width:'.$width.'ex"' : '').'>'.$columnName.'</div>';
}

/**
 * Генерирует код значения в столбце
 * @param   string    $value  значение
 * @param   integer   $width  ширина в ex
 * @param   string    $align  выравнивание text-align
 * 
 * @deprecated since version 0.16.4
 */
function render_column_value($value, $width = 0, $align = '')
{
  $style = '';
  $style .= ($width > 0) ? 'width:'.$width.'ex;' : '';
  $style .= ($align !== '') ? 'text-align:'.$align.';' : '';
  echo '<div class="columnValue"'.(($style !== '') ? ' style="'.$style.'"' : '').'>'.$value.'</div>';
}

/**
 * Генерирует код скрипта для отображения текущего времени
 * @param   string    $value  значение
 * @param   integer   $width  ширина в ex
 * @param   string    $align  выравнивание text-align
 * 
 * @deprecated since version 0.16.4
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