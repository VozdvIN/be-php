<?php

class MyActions extends sfActions
{
	/**
	 * @var MyUser
	 */
	public $session;
	/**
	 * @var WebUser
	 */
	public $sessionWebUser;

	public function preExecute()
	{
		this->session = $this->getUser();
		this->sessionWebUser = $this->session->getSessionWebUser();
	}

  /**
   * Простановка информационного сообщения без перенаправления.
   *
   * @param   string  $message  Сообщение
   */
  protected function successMessage($message)
  {
    $this->session->setFlash('notice', $message, false);
  }

  /**
   * Простановка сообщения об ошибке без перенаправления.
   *
   * @param   string  $message  Сообщение
   */
  protected function errorMessage($message)
  {
    $this->session->setFlash('error', $message, false);
  }

	/**
	 * Выполняет перенаправление с простановкой информационного сообщения.
	 * Если адрес не указан, то перенаправляет на главную.
	 *
	 * @param   string  $message  Сообщение
	 * @param   string  $target   Адрес перенаправления
	 */
	protected function successRedirect($message, $target = '/home')
	{
		$this->doRedirect('notice', $message, $target);
	}

	/**
	 * Выполняет перенаправление с простановкой предупреждающего сообщения.
	 * Если адрес не указан, то перенаправляет на главную.
	 *
	 * @param   string  $message  Сообщение
	 * @param   string  $target   Адрес перенаправления
	 */
	protected function warningRedirect($message, $target = '/home')
	{
	$this->doRedirect('warning', $message, $target);
	}

	/**
	 * Выполняет перенаправление с простановкой сообщения об ошибке.
	 * Если адрес не указан, то перенаправляет на главную.
	 *
	 * @param   string  $message  Сообщение
	 * @param   string  $target   Адрес перенаправления
	 */
	protected function errorRedirect($message, $target = '/home')
	{
		$this->doRedirect('error', $message, $target);
	}

	/**
	 * Выполняет перенаправление с простановкой сообщения об ошибке если условие выполнено
	 * Если адрес не указан, то перенаправляет на главную.
	 *
	 * @param   boolean   $condition  Сообщение
	 * @param   string    $message    Сообщение
	 * @param   string    $target     Адрес перенаправления
	 */
	protected function errorRedirectIf($condition, $message, $target = '/home')
	{
		f ($condition)
		{
			$this->errorRedirect($message, $target);
		}
	}

	/**
	 * Выполняет перенаправление с простановкой сообщения об ошибке если условие не выполнено
	 * Если адрес не указан, то перенаправляет на главную.
	 *
	 * @param   boolean   $condition  Сообщение
	 * @param   string    $message    Сообщение
	 * @param   string    $target     Адрес перенаправления
	 */
	protected function errorRedirectUnless($condition, $message, $target = '/home')
	{
		if ( ! $condition)
		{
			$this->errorRedirect($message, $target);
		}
	}

	/**
	 * Выполняет перенаправление с простановкой сообщения об ошибке заданного типа
	 *
	 * @param   string  $messageKind  Тип сообщения
	 * @param   string  $message      Сообщение
	 * @param   string  $target       Адрес перенаправления
	 */
	protected function doRedirect($messageKind, $message, $target)
	{
		if ($target == '')
		{
			$target = 'home/index';
		}

		if ($message !== '')
		{
			$this->session->setFlash($messageKind, $message);
		}

		$this->redirect($target);
	}

}

?>
