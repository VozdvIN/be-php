<h2>Выбор проекта</h2>

<ul class="pad-bottom">
	<?php if ($_selfRegionId != Region::DEFAULT_REGION): ?>
	<li class="info">
		<?php echo link_to('Свой проект (из анкеты)', 'region/setCurrent?id='.$_selfRegionId.'&returl='.$_retUrlRaw, array('method' => 'post')); ?>
	</li>
	<?php endif ?>
	<?php foreach($_regions as $region): ?>
	<li>
		<?php echo link_to($region->name, 'region/setCurrent?id='.$region->id.'&returl='.$_retUrlRaw, array('method' => 'post')); ?>
	</li>
	<?php endforeach; ?> 
</ul>

<p class="info">
	Если Вы хотите создать новый игровой проект, то <?php echo mail_to(SiteSettings::ADMIN_EMAIL_ADDR, 'напишите администраторам') ?>.
</p>
