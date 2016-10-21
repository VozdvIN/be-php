<h2>Игровые проекты</h2>

<table class="no-border">
	<thead>
		<tr><td colspan="2"><span class="button-info"><?php echo link_to('Создать проект', 'region/new'); ?></span></td></tr>
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
							'edit' => link_to('Править', 'region/edit?id='.$region->id),
							'delete' => link_to(
											'Удалить',
											'region/delete?id='.$region->id,
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
