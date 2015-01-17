<?php
class GameFormTemplates extends BaseGameForm
{

	public function configure()
	{
		unset($this['name']);
		unset($this['short_info']);
		unset($this['short_info_enabled']);
		unset($this['description']);
		unset($this['team_id']);
		unset($this['team_name_backup']);
		unset($this['region_id']);
		unset($this['start_briefing_datetime']);
		unset($this['start_datetime']);
		unset($this['stop_datetime']);
		unset($this['finish_briefing_datetime']);
		unset($this['time_per_game' ]);
		// unset($this['time_per_task']);
		// unset($this['time_per_tip']);
		// unset($this['try_count']);
		unset($this['update_interval']);
		unset($this['teams_can_update']);
		unset($this['update_interval_max']);
		// unset($this['task_define_default_name']);
		// unset($this['task_tip_prefix']);
		unset($this['status']);
		unset($this['started_at']);
		unset($this['finished_at']);
		unset($this['game_last_update']);

		$this->getWidgetSchema()->setLabels(array(
			'time_per_task' => 'Длительность задания:',
			'time_per_tip' => 'Интервал подсказок:',
			'try_count' => 'Неверных ответов:',
			'task_define_default_name' => 'Название формулировки:',
			'task_tip_prefix' => 'Префикс подсказки:',
		));
		
		$this->getWidgetSchema()->setHelps(array(
			'time_per_task' => 'мин.',
			'time_per_tip' => 'мин.|При добавлении новой подсказки ей будет установлена задержка, равная указанному значению умноженному на число имеющихся подсказок.',
			'try_count' => 'не&nbsp;более ... в рамках одного задания.',
			'task_define_default_name' => '',
			'task_tip_prefix' => 'При создании подсказки ее имя будет создано из этого префикса и числа существующих подсказок.',
		));
	}
}
