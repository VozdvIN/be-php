<h2>Подача заявки на создание игры</h2>

<?php if (SystemSettings::getInstance()->email_game_create): ?>
<p class="info">
	После подачи заявки подтвердите ее через ссылку из письма, которое будет Вам отправлено.
</p>
<?php else: ?>
<p>
	Игра будет создана после проверки заявки модератором.
</p>
<?php endif ?>
<p>
	При подтверждении заявки игра будет создана в игровом проекте команды-организатора.
</p>
<p>
	Позже руководитель игры может сменить игровой проект.
</p>
    
<?php include_partial('form', array('form' => $form)) ?>