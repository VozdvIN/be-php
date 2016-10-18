<?php
class teamCreateRequestActions extends MyActions
{

	public function preExecute()
	{
		parent::preExecute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$teamCreateRequest = new TeamCreateRequest();
		$teamCreateRequest->web_user_id = $this->sessionWebUser;
		$this->errorRedirectUnless(
			$this->canCreateNewRequest($teamCreateRequest->web_user_id),
			'От имени одного человека нельзя подавать более '.GameCreateRequest::MAX_REQUESTS_PER_TEAM.' заявок на создание команды. Отзовите предыдущие заявки или дождитесь их утверждения.'
		);
		$this->form = new TeamCreateRequestForm($teamCreateRequest);
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new TeamCreateRequestForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$teamCreateRequest = TeamCreateRequest::byId($request->getParameter('id')),
			'Заявка на создание команды не найдена'
		);

		$this->errorRedirectUnless(
			$this->sessionWebUser->id == $teamCreateRequest->web_user_id
			|| $this->sessionWebUser->can(Permission::TEAM_MODER, 0),
			'Отменить заявку на создание команды может только ее автор или модератор команд.',
			'webUser/showTeamsCreation?id='.$teamCreateRequest->web_user_id
		);

		$teamName = $teamCreateRequest->name;
		$webUser = $teamCreateRequest->WebUser;
		$teamCreateRequest->delete();
		Utils::sendNotifyUser(
			'Заявка отклонена - '.$teamName,
			'Ваша заявка на создание команды "'.$teamName.'" отклонена.',
			$webUser
		);

		$this->successRedirect(
			'Заявка на создание команды успешно отменена.',
			'webUser/showTeamsCreation?id='.$webUser->id
		);
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$object = $form->updateObject();
			if ((Utils::byField('Team', 'name', $object->name) === false)
				&& (Utils::byField('TeamCreateRequest', 'name', $object->name) === false))
			{
				$this->errorRedirectUnless(
					$this->canCreateNewRequest($object->web_user_id),
					'От имени одного человека нельзя подавать более '.TeamCreateRequest::MAX_REQUESTS_PER_USER.' заявок на создание команды. Отзовите предыдущие заявки или дождитесь их утверждения.',
					'/webUser/showTeamsCreation?id='.$object->web_user_id
				);

				$object->tag = Utils::generateActivationKey();
				$object = $form->save();

				$settings = SystemSettings::getInstance();
				if ($settings->email_team_create && !$settings->fast_team_create)
				{
					$notifyResult = Utils::sendNotify(
						'Создание команды '.$object->name,
						'Вы запросили создание команды "'.$object->name.'".'."\n"
						.'Для подтверждения создания команды перейдите по ссылке:'."\n"
						.'http://'.SiteSettings::SITE_DOMAIN.'/auth/createTeam?id='.$object->id.'&key='.$object->tag."\n"
						.'Отменить заявку можно здесь: http://'.SiteSettings::SITE_DOMAIN.'/team/index',
						$object->WebUser->email
					);

					if ($notifyResult)
					{
						$this->newTeamCreateRequestNotify($object);
						$this->successRedirect(
							'Заявка на создание команды '.$object->name.' принята. Вам отправлено письмо для ее подтверждения.',
							'/webUser/showTeamsCreation?id='.$object->web_user_id
						);
					}
					else
					{
						// Тут посылать письмо админам смысла нет...
						$this->warningRedirect(
							'Заявка на создание команды '.$object->name.' принята, но не удалось отправить письмо для ее подтверждения. Обратитесь к администрации сайта.',
							'/webUser/showTeamsCreation?id='.$object->web_user_id
						);
					}
				}
				else
				{
					$this->newTeamCreateRequestNotify($object);
					$this->successRedirect(
						'Заявка на создание команды '.$object->name.' принята. Ожидайте, пока она пройдет модерацию.',
						'/webUser/showTeamsCreation?id='.$object->web_user_id
					);
				}
			}
			else
			{
				$this->errorMessage('Не удалось подять заявку: команда или заявка с таким названием уже существует.');
			}
		}
	}

	public function executeAcceptManual(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$teamCreateRequest = TeamCreateRequest::byId($request->getParameter('id')),
			'Заявка на создание команды не найдена'
		);

		$fastTeamCreate = SystemSettings::getInstance()->fast_team_create;
		if ($fastTeamCreate)
		{
			$this->errorRedirectUnless(
				$this->sessionWebUser->id == $teamCreateRequest->web_user_id
					|| $this->sessionWebUser->can(Permission::TEAM_MODER, 0),
				'В режиме быстрого создания команд создать команду может только автор заявки.',
				'/webUser/showTeamsCreation?id='.$teamCreateRequest->web_user_id
			);
		}
		else
		{
			$this->errorRedirectUnless(
				$this->sessionWebUser->can(Permission::TEAM_MODER, 0),
				'Создать команду по заявке может только модератор команд.',
				'/webUser/showTeamsCreation?id='.$teamCreateRequest->web_user_id
			);
		}

		$this->errorRedirectUnless(
			Utils::byField('Team', 'name', $teamCreateRequest->name) === false,
			'Не удалось создать команду: команда '.$teamCreateRequest->name.' уже существует.',
			'/webUser/showTeamsCreation?id='.$teamCreateRequest->web_user_id
		);

		$webUser = $teamCreateRequest->WebUser;
		$team = TeamCreateRequest::doCreate($teamCreateRequest);
		Utils::sendNotifyUser(
			'Команда создана - '.$team->name,
			'Ваша заявка на создание команды "'.$team->name.'" утверждена, команда создана.'."\n"
			.'Страница команды: http://'.SiteSettings::SITE_DOMAIN.'/team/show?id='.$team->id,
			$webUser
		);

		$this->successRedirect(
			'Команда '.$team->name.' успешно создана.',
			'team/show?id='.$team->id
		);
	}

	protected function newTeamCreateRequestNotify(TeamCreateRequest $teamCreateRequest)
	{
		Utils::sendNotifyAdmin(
			'Новая команда - '.$teamCreateRequest->name,
			'Подана заявка на создание команды:'."\n"
			.'- название: '.$teamCreateRequest->name."\n"
			.'- автор заявки: '.$teamCreateRequest->WebUser->login.(($teamCreateRequest->WebUser->email !== '') ? ' ('.$teamCreateRequest->WebUser->email.')' : '')."\n"
			.'- сообщение: '.$teamCreateRequest->description."\n"
			.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/team/index'
		);
	}

	protected function canCreateNewRequest($userId)
	{
		$requests = Doctrine::getTable('TeamCreateRequest')
			->createQuery('tcr')
			->select()
			->where('web_user_id = ?', $userId)
			->execute();
		return $requests->count() < TeamCreateRequest::MAX_REQUESTS_PER_USER;
	}
}
?>