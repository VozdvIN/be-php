<?php

/**
 * Класс для хранения параметров, которые настраиваются один раз или редко изменяются.
 */
class SiteSettings
{
	/**
	 * Сдвиг времени сервера относительно времени хостинга (!), сек
	 * 
	 * В одном часе 3600 секунд.
	 * Для хостинга, работающего по московскому времени:
	 * - Калининград = -3600
	 * - Москва = -3600
	 * - Владивосток = +25200
	 */
	const SERVER_TIME_SHIFT = -3600;

	/**
	 * Название сайта, отображается в заголовке и указывается в письмах-уведомлениях.
	 */
	const SITE_NAME = "Beaver's Engine v0.16.3b";

	/**
	 * Домен сайта, требуется для формирования ссылок в письмах-уведомлениях
	 * Указывается без http:// и '/' на конце (!).
	 */
	const SITE_DOMAIN = 'localhost:8080';

	/**
	 * Адрес для связи с администрацией сайта.
	 */
	const ADMIN_EMAIL_ADDR = 'admin_login@host.zone';

	/**
	 * Обратный адрес для уведомлений, не предполагает прием ответов.
	 */
	const NOTIFY_EMAIL_ADDR = 'do_not_reply@host.zone';

	/** 
	 * Имя сервера SMTP, используемого для отправки уведомлений.
	 */
	const NOTIFY_SMTP_HOST = 'smtp.host.zone';

	/** 
	 * Порт сервера SMTP, используемого для отправки уведомлений:
	 * 
	 * - без шифрования: 25
	 * - tls: уточните у google или почтового провайдера.
	 * - ssl: 465
	 */
	const NOTIFY_SMTP_PORT = 25;

	/**
	 * Тип шифрования при отправке уведомлений:
	 * 
	 * - пустая строка - без шифрования
	 * - tls
	 * - ssl
	 */
	const NOTIFY_SMTP_SECURITY = '';

	/**
	 * Имя пользователя для авторизации на SMTP-сервере.
	 */
	const NOTIFY_SMTP_LOGIN = 'do_not_reply';

	/**
	 * Пароль пользователя для авторизации на SMTP-сервере.
	 */
	const NOTIFY_SMTP_PASSWORD = 'password';
}

/**
 * Класс для работы с временем
 */
class Timing
{
	const NO_DATE = '____:__:__';
	const NO_TIME = '--:--:--';

	/**
	 * Возвращает время сайта с учетом сдвига относительно времени хостера. 
	 */
	public static function getActualTime()
	{
		return time() + SiteSettings::SERVER_TIME_SHIFT;
	}

	/**
	 * Проверяет, отстоит ли $testTime от $baseTime не менее чем на $interval секунд.
	 *
	 * @param   integer   $testTime   Проверяемое время (время Unix)
	 * @param   integer   $interval   Интервал в секундах
	 * @param   integer   $baseTime   Время, от котого идет отсчет (время Unix)
	 * @return  boolean
	 */
	public static function isExpired($testTime, $interval, $baseTime)
	{
		return ($testTime - $baseTime) > $interval;
	}

	/**
	 * Возвращает отформатированную дату "ГГГГ-ММ-ДД ЧЧ:ММ:СС", соответствующую указанному времени.
	 *
	 * @param   integer   $timeDate   Время Unix
	 * @return  string
	 */
	public static function dateToStr($timeDate)
	{
		if ($timeDate == 0)
		{
			return Timing::NO_DATE.' '.Timing::NO_TIME;
		}

		return date('Y-m-d H:i:s', $timeDate + SiteSettings::SERVER_TIME_SHIFT);
	}

	/**
	 * Возвращает отформатированное время "ЧЧ:ММ:СС", соответствующую указанному времени.
	 *
	 * @param   integer   $time       Время Unix
	 * @return  string
	 */
	public static function timeToStr($time)
	{
		if ($time == 0)
		{
			return Timing::NO_TIME;
		}

		return date('H:i:s', $time + SiteSettings::SERVER_TIME_SHIFT);
	}

	/**
	 * Указанный в секундах интервал преобразует в соответствующее время "ЧЧ:ММ:СС".
	 * gmdate используется потому что интервал не нужно корректировать на местное время.
	 *
	 * @param   integer   $time       Интервал в секундах (время Unix)
	 * @return  string
	 */
	public static function intervalToStr($time)
	{
		if ($time == 0)
		{
			return Timing::NO_TIME;
		}

		return ($time > 0)
			? gmdate('H:i:s', $time)
			: '-'.gmdate('H:i:s', -1*$time);
	}

	/**
	 * Конвертирует строку вида "ГГГГ-ММ-ДД ЧЧ:ММ:СС" в метку времени Unix.
	 * 
	 * @todo Надо это как-то нормально реализовать, а не так криво. Как вообще mySql хранит timestamp?
	 * 
	 * @param   string  $dateStr
	 * @return  integer
	 */
	public static function strToDate($dateStr)
	{
		try
		{
			$parts = split(' ', $dateStr);
			$date = split('-', $parts[0]);
			$time = split(':', $parts[1]);
			return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]) - SiteSettings::SERVER_TIME_SHIFT;
		}
		catch (Exception $e)
		{
			return 'НеверныйФорматДаты';
		}
	}

}

/**
 * Класс для работы с Doctrine_Collection
 */
class DCTools
{
	/**
	 * Ищет в указанной коллекции запись с соответствующим id (это НЕ внутренный ключ коллекции).
	 * 
	 * @param   Doctrine_Collection   $collection
	 * @param   string                $id 
	 * 
	 * @return  Doctrine_Record       Или false, если не найдено.
	 */
	public static function recordById(Doctrine_Collection $collection, $id)
	{
		foreach ($collection as $item)
		{
			if ($item->id === $id)
			{
				return $item;
			}
		}
		
		return false;
	}

	/**
	 * Ищет в указанной коллекции запись с указанным значением в казанном поле
	 * 
	 * @param Doctrine_Collection $collection   Где искать
	 * @param string              $fieldName    В каком поле искать
	 * @param string              $value        Что искать
	 * 
	 * @return  Doctrine_Record       Или false, если не найдено.
	 */
	public static function recordByFieldValue(Doctrine_Collection $collection, $fieldName, $value)
	{
		foreach ($collection as $item)
		{
			if ($item->$fieldName === $value)
			{
				return $item;
			}
		}
		
		return false;
	}

	/**
	 * Возвращает все значения поля id в виде массива.
	 * 
	 * @param   Doctrine_Collection   $collection   Коллекция на обработку
	 * 
	 * @return  array
	 */
	public static function idsToArray(Doctrine_Collection $collection)
	{
		$res = array();
		foreach ($collection as $item)
		{
			array_push($res, $item->id);
		}
		
		return $res;
	}

	/**
	 * Возвращает все значения указанного поля в виде массива.
	 * 
	 * @param   Doctrine_Collection   $collection   Коллекция на обработку
	 * @param   string                $fieldName    Поле
	 * @param   boolean               $distinct     Не дублировать
	 * @param   boolean               $dropNulls    Не включать null значения
	 * 
	 * @return  array
	 */
	public static function fieldValuesToArray(Doctrine_Collection $collection, $fieldName, $distinct, $dropNulls)
	{
		$res = array();
		
		if ($dropNulls)
		{
			foreach ($collection as $item)
			{
				if ($item->$fieldName !== null)
				{
					array_push($res, $item->$fieldName);
				}
			}
		}
		else
		{
			foreach ($collection as $item)
			{
				array_push($item->$fieldName);
			}
		}
		
		return ($distinct) ? array_unique($res) : $res;
	}

}

/**
 * Класс вспомогательных инструментов
 */
class Utils
{
	const PASSWORD_SALT = 'cHaNgEtHiS';
	const ACTIVATION_KEY_LENGTH = 16;
	const MENU_BACK_BUTTON_TITLE = '&nbsp;&#094;&nbsp;';
	const CROSS_PAGE_LINK_MARKER = '...';
	const EXTERNAL_LINK_MARKER = '&#094;';

	const LOAD_TEST_MODE = false; // True - включить режим нагрузочного тестирования

	/**
	 * Сравнение двух многобайтовых строк без учета регистра.
	 * 
	 * @param type string
	 * @param type string
	 * @param type string
	 * @return bool
	 */
	public static function mb_strcasecmp($str1, $str2, $encoding = null)
    {
        if (null === $encoding)
		{
			$encoding = mb_internal_encoding();
		}
		return strcmp(mb_strtoupper($str1, $encoding), mb_strtoupper($str2, $encoding));
	}

	/**
	 * Возвращает хэш пароля с учетом "соления".
	 *
	 * @param   string  $password нешифрованный пароль
	 * @return  string
	 */
	public static function saltedPwdHash($password)
	{
		return md5($password.Utils::PASSWORD_SALT);
	}

	/**
	 * Генерирует ключ для активации чего-либо.
	 *
	 * @param   string  $base дополнительная часть к исходнику ключа
	 * @return  string
	 */
	public static function generateActivationkey($base = '')
	{
		return substr(md5($base.time().Utils::PASSWORD_SALT), 0, Utils::ACTIVATION_KEY_LENGTH);
	}

	/**
	 * Кодирует адрес обратного перехода, чтобы при записи в URL, он не нарушал правил маршрутизации
	 *
	 * @param   string  $sourceUrl  Исходный адрес
	 * @return  string              Шифрованный адрес
	 */
	public static function encodeSafeUrl($sourceUrl)
	{
		return base64_encode($sourceUrl);
	}

	/**
	 * Раскодирует адрес обратного перехода (после encodeSafeUrl)
	 *
	 * @param   string  $encodedUrl   Шифрованный адрес
	 * @return  string                Исходный адрес
	 */
	public static function decodeSafeUrl($encodedUrl)
	{
		return base64_decode($encodedUrl);
	}

	/**
	 * Возвращает все хранимые экземпляры указанного класса.
	 *
	 * @param   string              $className  Имя класса
	 * @param   string              $orderBy    Поле для сортировки
	 * @return  Doctrine_Collection             Или false, если нет результатов.
	 */
	public static function all($className, $orderBy = false)
	{
		if ( ! $orderBy)
		{
			$res = Doctrine::getTable($className)->findAll();
		}
		else
		{
			$res = Doctrine::getTable($className)
					->createQuery('q')
					->select()
					->orderBy($orderBy)
					->execute();
		}
		
		return ($res->count() > 0)
			? $res
			: false;
	}

	/**
	 * Возвращает экземпляры указанного класса по ключу.
	 * Не боится (в отличии от find) нулевых и отрицательных ключей.
	 *
	 * @param   string              $className  Имя класса
	 * @param   string              $id         Ключ хранимого экземпляра
	 * @return  Doctrine_Record     Или false, если нет результатов.
	 */
	public static function byId($className, $id)
	{
		return ($id <= 0) ? false : Doctrine::getTable($className)->find($id);
	}

	/**
	 * Возвращает все экземпляры класса, у которых в поле есть указанное значение.
	 * Определяет факт, что найдена только она запись, тогда ее и возвращает именно как запись.
	 *
	 * @param  string   $fieldName    Поле, в котором идет поиск
	 * @param  string   $fieldValue   Искомое значение
	 * @return mixed                  Doctrine_Collection если найдено более одной записи, Doctrine_Record если найдена только одна запись. False если нет результатов.
	 */
	public static function byField($className, $fieldName, $fieldValue)
	{
		if ($className === '' || $fieldName === '' || $fieldValue === '')
		{
			return false;
		}
		
		$res = Doctrine::getTable($className)->findBy($fieldName, $fieldValue);
		switch ($res->count())
		{
			case (0): return false;
			case (1): return $res[0];
			default: return $res;
		}
	}

	/**
	 * Возвращает все экземпляры класса, которые относятся к указанному игровому проекту.
	 * Если игровой проект не указан, то возвращает все экземпляры.
	 *
	 * @param  string               $className    Имя класса
	 * @param  mixed                $region       Игровой проект или null
	 * @return Doctrine_Collection
	 */
	public static function byRegion($className, $region, $orderField = 'name')
	{
		if ( ! ($region instanceof Region))
		{
			return new Doctrine_Collection($className);
		}

		$query = Doctrine::getTable($className)->createQuery('c')
			->select()
			->where('c.region_id = ?', $region->id)
			->orderBy('c.'.$orderField);

		if ($region->id == Region::DEFAULT_REGION)
		{
			$query->orWhere('(c.region_id IS NULL)');
		}

		return $query->execute();
	}

	/**
	 * Готовит сообщение о нехватке прав по указанным параметрам.
	 *
	 * @param   string  $userName       Имя пользователя
	 * @param   string  $messageEnding  Описание действия
	 * @return  string
	 */
	public static function cannotMessage($userName = 'Кто-то (скорее всего вы)', $messageEnding = 'так борзеть')
	{
		return $userName.' не имеет полномочий чтобы '.$messageEnding.'.';
	}

	/**
	 * Расшифровывает BB-код в исходной строке.
	 *
	 * @param   string  $text         Исходный текст
	 * @param   boolean $monospaced   Использовать моноширинный шрифт
	 * @return  string                HTML-код
	 */
	public static function decodeBB($text, $monospaced = false)
	{
		//TODO: Переделать так, чтобы можно было использовать вложенные тэги.
		$res = $text;
		//Принудительные пробелы
		$res = preg_replace('/\[_\]/', '&nbsp;', $res);
		$res = preg_replace('/\[tab\]/', '<span style="display:inline-block; width:4ex"></span>', $res);
		//Черта
		$res = preg_replace('/\[hr\]/', '<div class="border-top"></div>', $res);
		//Формат текста
		$res = preg_replace('/\[b\]([^\]]+)\[\/b\]/', '<span style="font-weight:bold">$1</span>', $res);
		$res = preg_replace('/\[i\]([^\]]+)\[\/i\]/', '<span style="font-style:italic">$1</span>', $res);
		$res = preg_replace('/\[u\]([^\]]+)\[\/u\]/', '<span style="text-decoration:underline">$1</span>', $res);
		$res = preg_replace('/\[s\]([^\]]+)\[\/s\]/', '<span style="text-decoration:line-through">$1</span>', $res);
		$res = preg_replace('/\[del\]([^\]]+)\[\/del\]/', '<span style="text-decoration:line-through">$1</span>', $res);
		$res = preg_replace('/\[color=(#[0-9a-fA-F]{6}|[a-z-]+)]([^\]]+)\[\/color\]/', '<span style="color:$1">$2</span>', $res);
		$res = preg_replace('/\[back=(#[0-9a-fA-F]{6}|[a-z-]+)]([^\]]+)\[\/back\]/', '<span style="background-color:$1">$2</span>', $res);
		//Формат текста предопределенный
		$res = preg_replace('/\[h1\]([^\]]+)\[\/h1\]/', '<h3>$1</h3>', $res);
		$res = preg_replace('/\[h2\]([^\]]+)\[\/h2\]/', '<h4>$1</h4>', $res);
		$res = preg_replace('/\[h3\]([^\]]+)\[\/h3\]/', '<h5>$1</h5>', $res);
		$res = preg_replace('/\[info\]([^\]]+)\[\/info\]/', '<span class="info">$1</span>', $res);
		$res = preg_replace('/\[warn\]([^\]]+)\[\/warn\]/', '<span class="warn">$1</span>', $res);
		$res = preg_replace('/\[danger\]([^\]]+)\[\/danger\]/', '<span class="danger">$1</span>', $res);
		//Ссылки
		$res = preg_replace('/\[url\]([^\]]+)\[\/url\]/', '<a href="$1">$1</a>', $res);
		$res = preg_replace('/\[url=([^\]]+)]([^\]]+)\[\/url\]/', '<a href="$1">$2</a>', $res);
		//Картинки
		$res = preg_replace('/\[img\]([^\]]+)\[\/img\]/', '<img src="$1" alt="$1" />', $res);
		$res = preg_replace('/\[img=([^\]]+)]/', '<img src="$1" alt="$1" />', $res);
		//Cсылки на статьи по названию
		$res = preg_replace('/\[\[([^\]]+)\]\]/', '<a href="/article/by/name/$1">$1</a>', $res);

		//Оформление переносов строк
		$res = preg_replace('/\n\r|\r\n/', "</p>\n\r<p>", $res);

		return $monospaced
			? '<p style="font-family:monospace">'.$res.'</p>'
			: '<p>'.$res.'</p>';
	}

	/**
	 * Создает и настраивает экземпляр SwiftMailer, параметры берутся из
	 * системных настроек. При неудаче соединения возвращает false.
	 * 
	 * @return  Swift_Mailer
	 */
	public static function getReadyMailer()
	{
		$transport = Swift_SmtpTransport::newInstance(SiteSettings::NOTIFY_SMTP_HOST, SiteSettings::NOTIFY_SMTP_PORT, SiteSettings::NOTIFY_SMTP_SECURITY);
		
		if ((SiteSettings::NOTIFY_SMTP_LOGIN !== null) && (SiteSettings::NOTIFY_SMTP_PASSWORD !== ''))
		{
			$transport->setUsername($settings->smtp_login)->setPassword($settings->smtp_password);
		}
		
		try
		{
			$transport->start();
		}
		catch (Exception $e)
		{
			return false;
		}
		
		return Swift_Mailer::newInstance($transport);
	}

	/**
	 * Отправляет сообщение при помощи указанного агента отправки
	 * 
	 * @param   Swift_Message   $message  сообщение
	 * @param                   $mailer   агент отправки
	 * 
	 * @return  boolean                   Результат операции
	 */
	public static function sendEmailSafe(Swift_Message $message, $mailer)
	{
		if ( ! ($mailer instanceof Swift_Mailer))
		{
			return false;
		}
		
		$isSent = false;
		
		try
		{
			$mailer = Utils::getReadyMailer();
			if ($mailer !== false) 
			{
				$isSent = $mailer->send($message);
			}
		}
		catch (Exception $e)
		{
			$isSent = false;
		}
		
		return $isSent;
	}

	/**
	 * Отправляет уведомление стандартного вида на один адрес.
	 * 
	 * @param   string    $topic    тема письма
	 * @param   string    $body     сообщение
	 * @param   string    $addrTo   адресат
	 * @return  boolean             Удачна ли была отправка
	 */
	public static function sendNotify($topic, $body, $addrTo)
	{
		if (    ! is_string($topic)
			 || ! is_string($body)
			 || ! is_string($addrTo) )
		{
			return false;
		}

		$settings = SystemSettings::getInstance();
		$bodyAll =
			"Здравствуйте!\n\n"
			.$body."\n\n"
			."Вы получили это письмо, так как зарегистрированы на сайте \"".SiteSettings::SITE_NAME."\".\n"
			."Если Вы не регистрировались на указанном сайте, просто проигнорируйте это письмо.\n"
			."Не отвечайте на это письмо! Оно было отправлено почтовым роботом.\n"
			."Для связи с администрацией сайта используйте адрес: ".SiteSettings::ADMIN_EMAIL_ADDR;
		$message = Swift_Message::newInstance($topic.' ('.SiteSettings::SITE_NAME.')')
			->setFrom(array(SiteSettings::NOTIFY_EMAIL_ADDR => SiteSettings::SITE_NAME))
			->setTo($addrTo)
			->setBody($bodyAll);
		return Utils::sendEmailSafe($message, Utils::getReadyMailer());
	}

	/**
	 * Отправляет уведомление стандартного вида пользователю.
	 * Если у пользователя нет e-mail-адреса в анкете - вернет false.
	 * 
	 * @param   string    $topic    тема письма
	 * @param   string    $body     сообщение
	 * @param   WebUser   $webUser  адресат
	 * @return  boolean             Удачна ли была отправка
	 */
	public static function sendNotifyUser($topic, $body, WebUser $webUser)
	{
		if ($webUser->email !== "")
		{
			return Utils::sendNotify($topic, $body, $webUser->email);
		}
		else
		{
			return false;
		}
	}

	/**
	 * Отправляет уведомление стандартного вида группе.
	 * Вернет true если хотя бы одна отправка удачна.
	 * 
	 * @param   string                        $topic  тема письма
	 * @param   string                        $body   сообщение
	 * @param   Doctrine_Collection<WebUser>  $group  адресаты
	 */ 
	public static function sendNotifyGroup($topic, $body, Doctrine_Collection $group)
	{
		$res = false;
		foreach ($group as $webUser)
		{
			if ($webUser instanceof WebUser)
			{
				//В одну строку следующие две не собирать,
				//иначе отправится только одному адресату.
				$try = Utils::sendNotifyUser($topic, $body, $webUser);
				$res = $try || $res;
			}
		}
		return $res;
	}

	/**
	 * Отправляет уведомление стандартного вида администратору.
	 * 
	 * @param   string    $topic  тема письма
	 * @param   string    $body   сообщение
	 * @return  boolean           Удачна ли была отправка
	 */
	public static function sendNotifyAdmin($topic, $body)
	{
		Utils::sendNotify($topic, $body, SiteSettings::ADMIN_EMAIL_ADDR);
	}
}
?>
