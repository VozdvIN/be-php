<?php
	$retUrlRaw = Utils::encodeSafeUrl('webUser/show?id='.$_webUser->id);
?>

<?php
	include_partial(
		'menu',
		array(
			'_webUser' => $_webUser,
			'_activeItem' => $_webUser
		)
	)
?>

<?php if ($_isSelf): ?>
<p class="info info-bg">
	Это Ваша анкета.
</p>
<?php endif ?>

<?php if ( ! $_webUser->is_enabled): ?>
<p class="warn warn-bg">
	Этот пользователь заблокирован.
</p>
<?php endif ?>

<table class="no-border">
	<tbody>
		<tr><th>Псевдоним:</th><td><?php echo $_webUser->login; ?></td></tr>
		<tr><th>Ф.И.(О.):</th><td><?php echo $_webUser->full_name; ?></td></tr>
		<tr><th>Проект:</th><td><?php echo $_webUser->getRegionSafe()->name; ?></td></tr>
		<?php if ($_isModerator): ?>
		<tr><th>Id:</th><td><?php echo $_webUser->id; ?></td></tr>
		<tr><th>E-Mail:</th><td><?php echo $_webUser->email; ?></td></tr>
		<tr><th>Тэг:</th><td><?php echo $_webUser->tag; ?></td></tr>
		<?php endif; ?>
	</tbody>
</table>