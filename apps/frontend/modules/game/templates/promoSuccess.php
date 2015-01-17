<?php
	include_partial(
		'gameMenu',
		array(
			'_game' => $_game,
			'_activeItem' => 'Информация',
			'_isModerator' => $_isModerator
		)
	)
?>

<h3>Информация</h3>

<table class="no-border">
	<tbody>
		<tr>
			<th>Название:</th>
			<td><?php echo $_game->name; ?></td>
		</tr>
		<tr>
			<th>Проект:</th>
			<td><?php echo $_game->getRegionSafe()->name; ?></td>
		</tr>
		<tr>
			<th>Организаторы:</th>
			<td><?php echo ($_game->team_id <= 0) ? $_game->getTeamBackupName() : link_to($_game->Team->name, 'team/show?id='.$_game->Team->id, array ('target' => '_blank')) ?></td>
		</tr>
		<tr>
			<th>Анонсирована:</th>
			<td><?php echo ($_game->short_info_enabled) ? 'Да' : 'Нет' ?></td>
		</tr>
		<tr>
			<th>Анонс:</th>
			<td><a target="_self" href="#announce">см. ниже</a></td>
		</tr>
		<tr>
			<th>Описание:</th>
			<td><a target="_self" href="#info">см. ниже</a></td>
		</tr>
		<tr>
			<th>Брифинг:</th>
			<td><?php echo $_game->start_briefing_datetime ?></td>
		</tr>
		<tr>
			<th>Старт:</th>
			<td><?php echo $_game->start_datetime ?></td>
		</tr>
		<tr>
			<th>Длительность:</th>
			<td><?php echo Timing::intervalToStr($_game->time_per_game*60) ?></td>
		</tr>
		<tr>
			<th>Остановка:</th>
			<td><?php echo $_game->stop_datetime ?></td>
		</tr>
		<tr>
			<th>Подведение итогов:</th>
			<td><?php echo $_game->finish_briefing_datetime ?></td>
		</tr>		
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="2">
				<?php if ($_canManage || $_isModerator): ?>
				<p>
					<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'game/promoEdit?id='.$_game->id) ?></span>
					<?php if ($_isModerator): ?>
						<span class="danger danger-bg pad-box box"><?php echo link_to('Удалить игру', 'game/delete?id='.$_game->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить игру '.$_game->name.'?')) ?></span>
					<?php endif; ?>				
				</p>
				<?php endif; ?>
			</td>
		</tr>
	</tfoot>
</table>

<a name="announce"></a>
<h3>Предпросмотр анонса</h3>
<article>
	<?php echo Utils::decodeBB($_game->short_info) ?>
</article>

<a name="info"></a>
<h3>Предпросмотр описания</h3>
<article>
	<?php echo Utils::decodeBB($_game->description) ?>
</article>
