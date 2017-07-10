<?php

class moderationActions extends myActions
{
	public function executeShow()
	{
		$this->setModerationFlags();
		$this->_webUser = WebUser::byId($this->sessionWebUser->id);
	}

	/* Settings */

	public function executeSettings()
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать системные настройки'));
		$this->_settings = SystemSettings::getInstance();
		$this->setModerationFlags();
	}

	public function executeSettingsEdit(sfWebRequest $request)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать системные настройки'));
		$system_settings = SystemSettings::getInstance();
		$this->form = new SystemSettingsForm($system_settings);
	}

	public function executeSettingsUpdate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$system_settings = SystemSettings::getInstance();
		$this->form = new SystemSettingsForm($system_settings);
		$this->processSettingsForm($request, $this->form);
		$this->setTemplate('edit');
	}

	protected function processSettingsForm(sfWebRequest $request, sfForm $form)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать системные настройки'));
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$system_settings = $form->save();
			$this->successRedirect('Системные настройки успешно сохранены.', 'moderation/settings');
		}
		else
		{
			$this->errorMessage('Сохранить системные настройки не удалось. Исправьте ошибки и попробуйте снова.');
		}
	}

	public function executeRegions()
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список игровых проектов'));
		$this->_settings = SystemSettings::getInstance();
		$this->setModerationFlags();
		$this->_regions = Doctrine_Core::getTable('Region')
			->createQuery('r')
			->select()
			->orderBy('r.name')
			->execute();
	}

	public function executeSmtpTest()
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'тестировать отправку писем'));

		$mailer = Utils::getReadyMailer();
		if ( ! $mailer)
		{
			$this->errorRedirect('Не удается соединиться с SMTP-сервером. Проверьте настройки имени SMTP-сервера, номера порта и способа шифрования.', 'moderation/show');
		}
		else
		{
			$message = Swift_Message::newInstance('Тестирование почты '.SiteSettings::SITE_NAME)
				->setFrom(array(SiteSettings::NOTIFY_EMAIL_ADDR => SiteSettings::SITE_NAME))
				->setTo(SiteSettings::ADMIN_EMAIL_ADDR)
				->setBody('Тестирование отправки уведомлений');

			if (Utils::sendEmailSafe($message, $mailer))
			{
				$this->successRedirect('Тестовое уведомление успешно отправлено на '.SiteSettings::ADMIN_EMAIL_ADDR.'.', 'moderation/settings');
			}
			else
			{
				$this->errorRedirect('Соединение с SMTP-сервером установлено, но отправка тестового письма не удалась. Проверьте корректность обратого адреса, аккаунта и логина SMTP-сервера.', 'moderation/settings');
			}
		}
	}

	/* Regions */

	public function executeRegionNew(sfWebRequest $request)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'создавать игровые проекты'));
		$this->form = new RegionForm();
	}

	public function executeRegionCreate(sfWebRequest $request)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'создавать игровые проекты'));
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new RegionForm();
		$this->processRegionForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeRegionEdit(sfWebRequest $request)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игровые проекты'));
		$this->forward404Unless($region = Doctrine_Core::getTable('Region')->find(array($request->getParameter('id'))), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
		$this->form = new RegionForm($region);
	}

	public function executeRegionUpdate(sfWebRequest $request)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'редактировать игровые проекты'));
		$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
		$this->forward404Unless($region = Doctrine_Core::getTable('Region')->find(array($request->getParameter('id'))), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
		$this->form = new RegionForm($region);
		$this->processRegionForm($request, $this->form);
		$this->setTemplate('edit');
	}

	public function executeRegionDelete(sfWebRequest $request)
	{
		$this->errorRedirectIf( ! $this->sessionWebUser->canExact(Permission::ROOT, 0), Utils::cannotMessage($this->sessionWebUser->login, 'удалять игровые проекты'));
		$request->checkCSRFProtection();
		$this->forward404Unless($region = Doctrine_Core::getTable('Region')->find(array($request->getParameter('id'))), sprintf('Object region does not exist (%s).', $request->getParameter('id')));
		if ($region->id == Region::DEFAULT_REGION)
		{
			$this->errorRedirect('Нельзя удалять игровой проект, используемый по умолчанию.', 'moderation/regions');
		}
		$region->delete();
		$this->successRedirect('Игровой проект успешно удален.', 'moderation/regions');
	}

	protected function processRegionForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$region = $form->save();
			$this->successRedirect('Игровой проект успешно сохранен.', 'moderation/regions');
		}
	}

	/* WebUsers */

	public function executeUsers()
	{
		$this->setModerationFlags();
		$this->errorRedirectIf( ! $this->_isWebUserModer, Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список пользователей'));
		$this->_webUsers = WebUser::allSorted();
	}

	public function executeUsersBlocked()
	{
		$this->setModerationFlags();
		$this->errorRedirectIf( ! $this->_isWebUserModer, Utils::cannotMessage($this->sessionWebUser->login, 'просматривать список пользователей'));
		$this->_webUsers = WebUser::allBlockedSorted();
	}

	/* Self */

	protected function setModerationFlags()
	{
		$this->_isAdmin = $this->sessionWebUser->canExact(Permission::ROOT, 0);
		$this->_isWebUserModer = $this->sessionWebUser->can(Permission::WEB_USER_MODER, 0);
		$this->_isFullTeamModer = $this->sessionWebUser->can(Permission::TEAM_MODER, 0);
		$this->_isFullGameModer = $this->sessionWebUser->can(Permission::GAME_MODER, 0);
	}
}
