<?php include_partial('breadcrumbs') ?>

<?php include_partial('menu', array(
	'_activeItem' => 'Проекты',
	'_isAdmin' => $_isAdmin,
	'_isWebUserModer' => $_isWebUserModer,
	'_isFullTeamModer' => $_isFullTeamModer,
	'_isFullGameModer' => $_isFullGameModer
)) ?>

<table class="no-border">
	<thead>
		<tr><td colspan="2"><span class="button-info"><?php echo link_to('Создать проект', 'moderation/regionNew'); ?></span></td></tr>
	</thead>
	<tbody>
		<?php foreach ($_regions as $region): ?>
		<tr>
			<td><?php echo $region->name ?></td>
			<td>
				<?php
				include_partial(
					'global/actionsMenu',
					array(
						'items' => array(
							'edit' => link_to('Править', 'moderation/regionEdit?id='.$region->id),
							'delete' => link_to(
											'Удалить',
											'moderation/regionDelete?id='.$region->id,
											array(
												'method' => 'delete',
												'confirm' => 'Вы правда хотите удалить игровой проект '.$region->name.' ?'
											)
										)
						),
						'css' => array(
							'edit' => 'info',
							'delete' => 'danger'
						)
					)
				);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>