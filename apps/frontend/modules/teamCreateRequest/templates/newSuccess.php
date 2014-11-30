<?php render_breadcombs(array(link_to('Команды', 'team/index'))) ?>

<h2>Подача заявки на создание команды</h2>

<?php if (SystemSettings::getInstance()->fast_team_create): ?>
<p class="info">
	Разрешено создание команд без модерирования: после подачи заявки подтвердите ее самостоятельно на странице со списком команд.
</p>
<?php elseif (SystemSettings::getInstance()->email_team_create): ?>
<p>
	После подачи заявки подтвердите ее через ссылку из письма, которое будет Вам отправлено.
</p>
<?php else: ?>
<p>
	Команда будет создана после проверки заявки модератором.
</p>
<?php endif ?>

<p>
	После подтверждения заявки команда будет зарегистрирована в игровом проекте автора заявки.
</p>
<p>
	Позже капитан команды (или модератор) может сменить игровой проект команды.
</p>

<?php include_partial('global/formCrud', array('form' => $form, 'moduel' => 'teamCreateRequest')) ?>
