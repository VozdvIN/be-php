<?php include_partial('breadcrumbs', array('_team' => $_team)) ?>
<?php include_partial('menu', array('_activeItem' => 'Данные', '_team' => $_team)) ?>

<table class="no-border">
	<thead>
		<tr>
			<td colspan="2">
				<?php
					include_partial('global/actionsMenu',
						array(
							'items' => array(
								'Edit' => link_to('Редактировать', 'team/edit?id='.$_team->id),
								'Delete' => link_to('Удалить', 'team/delete?id='.$_team->id, array('method' => 'delete', 'confirm' => 'Вы точно хотите удалить команду '.$_team->name.'?'))
							),
							'css' => array(
								'Edit' => '',
								'Delete' => 'danger'
							),
							'conditions' => array(
								'Edit' => $_sessionIsLeader || $_sessionIsModerator,
								'Delete' => $_sessionIsModerator
							)
						)
					);
				?>
			</td>
		</tr>
	</thead>
	<tbody>
		<tr><th>Название:</th><td><?php echo $_team->name; ?></td></tr>
		<tr><th>Полностью:</th><td><?php echo $_team->full_name; ?></td></tr>
		<tr><th>Проект:</th><td><?php echo $_team->getRegionSafe()->name; ?></td></tr>
		<?php if ($_sessionIsModerator): ?>
		<tr><th>Id:</th><td><?php echo $_team->id; ?></td></tr>
		<?php endif; ?>
	</tbody>
	<tfoot>
</table>