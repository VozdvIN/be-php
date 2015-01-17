<?php
class GameFormPromo extends BaseGameForm
{

	public function configure()
	{
		// unset($this['name']);
		// unset($this['short_info']);
		// unset($this['short_info_enabled']);
		// unset($this['description']);
		// unset($this['team_id']);
		unset($this['team_name_backup']);
		// unset($this['region_id']);
		unset($this['start_briefing_datetime']);
		unset($this['start_datetime']);
		unset($this['stop_datetime']);
		unset($this['finish_briefing_datetime']);
		unset($this['time_per_game' ]);
		unset($this['time_per_task']);
		unset($this['time_per_tip']);
		unset($this['try_count']);
		unset($this['update_interval']);
		unset($this['teams_can_update']);
		unset($this['update_interval_max']);
		unset($this['task_define_default_name']);
		unset($this['task_tip_prefix']);
		unset($this['status']);
		unset($this['started_at']);
		unset($this['finished_at']);
		unset($this['game_last_update']);

		$this->getWidgetSchema()->setLabels(array(
			//Общее
			'name' => '* Название:',
			'short_info' => '* Анонс:',
			'short_info_enabled' => 'Анонсирована:',
			'description' => '* Описание:',
			'team_id' => 'Организаторы:',
			'region_id' => 'Проект:',
		));
		
		$this->getWidgetSchema()->setHelps(array(
			//Общее
			'name' => '',
			'team_id' => 'Команда организаторов. Если Вы измените это поле, то можете потерять возможность редактирования игры!',
			'description' => '',
			'short_info' => 'Информация об игре на главной странице. Лучше максимально кратко.',
			'short_info_enabled' => 'Показывать анонс на главной странице.',
			'region_id' => 'Проект, организующий игру. Не препятствует участию команд из других проектов.',
		));
	}
}
