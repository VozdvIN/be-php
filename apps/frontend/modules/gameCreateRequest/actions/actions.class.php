<?php
/**
 * gameCreateRequest actions.
 *
 * @package    sf
 * @subpackage gameCreateRequest
 * @author     VozdvIN
 */

class gameCreateRequestActions extends MyActions
{

	public function preExecute()
	{
		parent::preExecute();
	}

	public function executeNew(sfWebRequest $request)
	{
		$this->errorRedirectUnless(
			$team = Team::byId($request->getParameter('teamId')),
			'Не указана команда, которая организует игру'
		);

		$this->errorRedirectUnless(
		$this->canCrateNewRequest($team->id),
			'От имени одной команды нельзя подавать более '.GameCreateRequest::MAX_REQUESTS_PER_TEAM.' заявок на создание игры. Отзовите предыдущие заявки или дождитесь их утверждения.',
			'team/showAuthorsCreation?id='.$team->id
		);

		$gameCreateRequest = new gameCreateRequest();
		$gameCreateRequest->team_id = $team->id;
		$this->form = new GameCreateRequestForm($gameCreateRequest);
	}

	public function executeCreate(sfWebRequest $request)
	{
		$this->forward404Unless($request->isMethod(sfRequest::POST));
		$this->form = new GameCreateRequestForm();
		$this->processForm($request, $this->form);
		$this->setTemplate('new');
	}

	public function executeDelete(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->forward404Unless(
			$gameCreateRequest = GameCreateRequest::byId($request->getParameter('id')),
			'Заявка на создание игры не найдена'
		);
		$this->errorRedirectUnless(
			$gameCreateRequest->Team->canBeManaged($this->sessionWebUser) || $this->sessionWebUser->can(Permission::GAME_MODER, 0),
			'Отменить заявку на создание игры может только капитан команды организаторов или модератор игр.',
			'team/showAuthorsCreation?id='.$gameCreateRequest->Team->id
		);

		$team = $gameCreateRequest->Team;
		$gameName = $gameCreateRequest->name;
		$gameCreateRequest->delete();

		Utils::sendNotifyGroup(
			'Заявка отклонена - '.$gameName,
			'Заявка вашей команды "'.$team->name.'" на создание игры "'.$gameName.'" отклонена.',
			$team->getLeadersRaw()
		);

		$this->successRedirect('Заявка на создание игры успешно отменена.', 'team/showAuthorsCreation?id='.$gameCreateRequest->Team->id);
	}

	protected function processForm(sfWebRequest $request, sfForm $form)
	{
		$form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
		if ($form->isValid())
		{
			$object = $form->updateObject();
			if ((Utils::byField('Game', 'name', $object->name) === false)
				&& (Utils::byField('GameCreateRequest', 'name', $object->name) === false))
			{
				$this->errorRedirectUnless(
					$this->canCrateNewRequest($object->team_id),
					'От имени одной команды нельзя подавать более '.GameCreateRequest::MAX_REQUESTS_PER_TEAM.' заявок на создание игры.',
					'team/showAuthorsCreation?id='.$object->team_id
				);

				$object->tag = Utils::generateActivationkey();
				$object = $form->save();

				$settings = SystemSettings::getInstance();
				if ($settings->email_game_create)
				{
					$notifyResult = Utils::sendNotifyGroup(
						'Создание игры '.$object->name,
						'Ваша команда "'.$object->Team->name.'" запросила создание игры "'.$object->name.'"'."\n"
						.'Для подтверждения создания игры перейдите по ссылке:'."\n"
						.'http://'.SiteSettings::SITE_DOMAIN.'/auth/createGame?id='.$object->id.'&key='.$object->tag."\n"
						.'Отменить заявку можно здесь: http://'.SiteSettings::SITE_DOMAIN.'/game/index',
						$object->Team->getLeadersRaw()
					);

					if ($notifyResult)
					{
						$this->newGameCreateRequestNotify($object);
						$this->successRedirect(
							'Заявка на создание игры '.$object->name.' принята. Вам отправлено письмо для ее подтверждения.',
							'team/showAuthorsCreation?id='.$object->team_id
						);
					}
					else
					{
						// Писать админам смысла нет.
						$this->warningRedirect(
							'Заявка на создание игры '.$object->name.' принята, но не удалось отправить письмо для ее подтверждения. Обратитесь к администрации сайта.',
							'team/showAuthorsCreation?id='.$object->team_id
						);
					}
				}
				else
				{
					$this->newGameCreateRequestNotify($object);
					$this->successRedirect(
						'Заявка на создание игры '.$object->name.' принята. Ожидайте, пока она пройдет модерацию.', 
						'team/showAuthorsCreation?id='.$object->team_id
					);
				}
			}
			else
			{
				$this->errorMessage('Не удалось подять заявку: игра или заявка с таким названием уже существует.');
			}
		}
	}

	/**
	 * @deprecated Подача заявки на создание игры выполняется из профиля подающей заявку команды
	 */
	public function executeNewManual(sfWebRequest $request)
	{
		throw new Exception("gameCreateRequest::executeNewManual: DEPRECATED");
/*
		$this->_teams = new Doctrine_Collection('Team');
		foreach (Doctrine::getTable('Team')->findAll() as $team)
		{
			if ($team->canBeManaged($this->sessionWebUser))
			{
				$this->_teams->add($team);
			}
		}

		$this->errorRedirectIf($this->_teams->count() <= 0, 'Нет команд, от лица которых вы можете подать заявку на создание игры.');
*/
	}

	public function executeAcceptManual(sfWebRequest $request)
	{
		$request->checkCSRFProtection();
		$this->errorRedirectUnless(
			$gameCreateRequest = GameCreateRequest::byId($request->getParameter('id')),
			'Заявка на создание игры не найдена',
			'game/index'
		);

		$this->errorRedirectUnless(
			$this->sessionWebUser->can(Permission::GAME_MODER, 0),
			'Создать игру по заявке может только модератор игр.',
			'game/index'
		);

		$this->errorRedirectUnless(
			Utils::byField('Game', 'name', $gameCreateRequest->name) === false,
			'Не удалось создать игру: игра '.$gameCreateRequest->name.' уже существует.',
			'team/index'
		);

		$team = $gameCreateRequest->Team;
		$game = GameCreateRequest::doCreate($gameCreateRequest);
		Utils::sendNotifyGroup(
			'Игра создана - '.$game->name,
			'Заявка вашей команды "'.$team->name.'" на создание игры "'.$game->name.'" утверждена, игра создана.'."\n"
			.'Страница игры: http://'.SiteSettings::SITE_DOMAIN.'/game/promo?id='.$game->id,
			$team->getLeadersRaw()
		);

		$this->successRedirect('Игра '.$game->name.' успешно создана.', 'game/index');
	}

	protected function newGameCreateRequestNotify(GameCreateRequest $gameCreateRequest)
	{
		Utils::sendNotifyAdmin(
			'Новая игра - '.$gameCreateRequest->name,
			'Подана заявка на создание игры:'."\n"
			.'- название: '.$gameCreateRequest->name."\n"
			.'- команда-организатор: '.$gameCreateRequest->Team->name."\n"
			.'- сообщение: '.$gameCreateRequest->description."\n"
			.'Утвердить или отклонить: http://'.SiteSettings::SITE_DOMAIN.'/game/index'
		);
	}

	protected function canCrateNewRequest($teamId)
	{
		$requests = Doctrine::getTable('GameCreateRequest')
			->createQuery('gcr')
			->select()
			->where('team_id = ?', $teamId)
			->execute();

		return $requests->count() < GameCreateRequest::MAX_REQUESTS_PER_TEAM;
	}
}
?>