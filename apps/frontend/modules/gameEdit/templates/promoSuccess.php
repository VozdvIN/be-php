<?php include_partial('menu', array('_game' => $_game, '_activeItem' => '')) ?>

<table class="no-border">
	<tbody>
		<tr><th>Название:</th><td><?php echo $_game->name; ?></td></tr>
		<tr><th>Проект:</th><td><?php echo $_game->getRegionSafe()->name; ?></td></tr>
		<tr><th>Организаторы:</th><td><?php echo ($_game->team_id <= 0) ? $_game->getTeamBackupName() : link_to($_game->Team->name, 'team/show?id='.$_game->Team->id, array ('target' => '_blank')) ?></td></tr>
		<tr><th>Анонсирована:</th><td><?php echo ($_game->short_info_enabled) ? 'Да' : 'Нет' ?></td></tr>
		<tr><th>Анонс:</th><td><?php echo link_to('см. афишу', 'game/show?id='.$_game->id, array('target' => '_blank')); ?></td></tr>
		<tr><th>Описание:</th><td><?php echo link_to('см. афишу', 'game/show?id='.$_game->id, array('target' => '_blank')); ?></td></tr>
		<tr><th>Брифинг:</th><td><?php echo $_game->start_briefing_datetime ?></td></tr>
		<tr><th>Старт:</th><td><?php echo $_game->start_datetime ?></td></tr>
		<tr><th>Длительность:</th><td><?php echo Timing::intervalToStr($_game->time_per_game*60) ?></td></tr>
		<tr><th>Остановка:</th><td><?php echo $_game->stop_datetime ?></td></tr>
		<tr><th>Подведение итогов:</th><td><?php echo $_game->finish_briefing_datetime ?></td></tr>
	</tbody>

	<tfoot>
		<tr>
			<td colspan="2">
				<?php
					include_partial(
						'global/actionsMenu',
						array(
							'items' => array(
								'edit' => link_to('Редактировать', 'gameEdit/promoEdit?id='.$_game->id),
								'delete' => link_to(
									'Удалить игру',
									'gameEdit/delete?id='.$_game->id,
									array(
										'method' => 'delete',
										'confirm' => 'Вы точно хотите удалить игру '.$_game->name.'?'
									)
								),
							),
							'css' => array(
								'edit' => '',
								'delete' => 'danger'
							),
							'conditions' => array(
								'edit' => $_canManage || $_isModerator,
								'delete' => $_isModerator
							)
						)
					);
				?>
			</td>
		</tr>
	</tfoot>
</table>
