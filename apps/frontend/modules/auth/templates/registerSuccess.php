<h2>Регистрация</h2>

<article>
	<?php include './config/layout/offer.html'; ?>
</article>

<div>
	<?php include_partial('global/formSimple', array('form' => $form, 'url' => 'auth/register', 'commitLabel' => 'Зарегистрироваться')); ?>
</div>

<div></div>
<p class="warn">
	Перед вводом пароля проверьте:
</p>
<ul>
	<li>какой язык включен;</li>
	<li>выключен ли CAPS&nbsp;LOCK;</li>
	<li>в нужном ли состоянии NUM&nbsp;LOCK.</li>
</ul>
<p class="warn">
	Настоятельно рекомендуется, чтобы пароль удовлетворял следующим критериям:
</p>
<ul>
	<li>включал минимум две цифры, две заглавные и две строчные буквы;</li>
	<li>не содержал очевидных последовательностей вроде "123", "abc", "qwerty" и т.п.;</li>
	<li>не содержал имени пользователя, указанного в первом поле;</li>
	<li>не содержал широко известных личных данных вроде имени, даты рождения, номера телефона, адреса и т.п.</li>
</ul>
<p>
	Соблюдение этих рекомендаций значительно снизит риск его взлома.
</p>
<p class="warn">
	Рекомендуется указывать действующий адрес электронной почты, чтобы была возможность активировать учетную запись.
</p>
