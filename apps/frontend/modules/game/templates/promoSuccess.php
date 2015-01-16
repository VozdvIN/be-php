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

<h2>Информация</h2>

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
			<th>Анонс опубликован:</th>
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
	</tbody>
	
	<tfoot>
		<tr>
			<td colspan="2">
				<?php if ($_canManage || $_isModerator): ?>
				<p>
					<span class="info info-bg pad-box box"><?php echo link_to('Редактировать', 'game/promoEdit?id='.$_game->id) ?></span>
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
