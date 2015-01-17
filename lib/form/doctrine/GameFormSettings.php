<?php
class GameFormSettings extends BaseGameForm
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
		unset($this['time_per_task']);
		unset($this['time_per_tip']);
		unset($this['try_count']);
		// unset($this['update_interval']);
		// unset($this['teams_can_update']);
		// unset($this['update_interval_max']);
		unset($this['task_define_default_name']);
		unset($this['task_tip_prefix']);
		unset($this['status']);
		unset($this['started_at']);
		unset($this['finished_at']);
		unset($this['game_last_update']);

		$this->getWidgetSchema()->setLabels(array(
			'update_interval' => 'Интервал пересчета:',
			'teams_can_update' => 'Пересчет командами:',
			'update_interval_max' => 'Максимальная задержка:'
		));
		
		$this->getWidgetSchema()->setHelps(array(
			'update_interval' => 'раз&nbsp;в&nbsp;...&nbsp;с.|Автообновление нужно запускать вручную со страницы управления игрой.',
			'teams_can_update' => 'Пересчет состояния будет выполнятся индивидуально для каждой команды в момент обновления ею страницы задания.|Отключает учет максимального интервала между обновлениями.',
			'update_interval_max' => 'с.|Если пересчет состояния будет выполнен с интервалом больше указанного здесь, то игровое время команды сдвинется только на этот интервал, а остальное время будет списано в простой.|Не учитывается, если командам разрешен пересчет состояния.'
		));
	}
}
