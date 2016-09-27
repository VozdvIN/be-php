<h6>Выберите проект:</h6>

<ul>
	<?php if ($_selfRegionId != Region::DEFAULT_REGION): ?>
	<li class="box"><?php echo link_to('Свой проект (из профиля)', 'region/setCurrent?id='.$_selfRegionId.'&returl='.$_retUrlRaw, array('method' => 'post')); ?></li>
	<?php endif ?>
	<?php foreach($_regions as $region): ?>
	<li class="box"><?php echo link_to($region->name, 'region/setCurrent?id='.$region->id, array('method' => 'post')); ?></li>
	<?php endforeach; ?> 
</ul>

<p class="info">
	Если Вы хотите создать новый игровой проект, то <?php echo mail_to(SiteSettings::ADMIN_EMAIL_ADDR, 'напишите администраторам') ?>.
</p>
