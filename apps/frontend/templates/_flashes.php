<?php
$notice = $sf_user->getFlash('notice');
$warning = $sf_user->getFlash('warning');
$error = $sf_user->getFlash('error');
?>
<?php if (isset($notice)): ?>
<p class="info info-bg">
	<?php echo $notice ?>
</p>
<?php endif; ?>
<?php if (isset($warning)): ?>
<p class="warn warn-bg">
	<?php echo $warning ?>
</p>
<?php endif; ?>
<?php if (isset($error)): ?>
<p class="danger danger-bg">
	<?php echo $error ?>
</p>
<?php endif; ?>