<h2>Регистрация</h2>

<?php if ($agreementArticle = Article::byName('Шаблонные-ПользовательскоеСоглашение')):?>
<?php   echo Utils::decodeBB($agreementArticle->text); ?>
<?php else: ?>
<div class="warn">
    <p>
        Внимательно прочитайте нижеизложенное!
    </p>
</div>
<h3>Пользовательское соглашение</h3>
    <p>
        Создавая учетную запись (далее &quot;аккаунт&quot;) на данном сайте (далее &quot;Система&quot;) вы соглашаетесь с тем, что:
    </p>
<ol>
    <li>Вы используете Систему исключительно на свой страх и риск.</li>
    <li>Разработчики и администрация Системы не предоставляют абсолютно никаких гарантий корректной и бесперебойной работы Системы.</li>
    <li>Разработчики и администрация Системы не могут быть привлечены к какой либо ответственности за прямой или косвенный ущерб, связанный с использованием, некорректной работой или невозможностью использовать Систему.</li>
    <li>Вам может быть отказано в регистрации и/или приостановлен доступ к Системе без объяснения причин.</li>
    <li>Все действия, производимые в Системе, подтверждаемые вашими именем и паролем однозначно считаются выполняемыми лично Вами.</li>
    <li>Вы самостоятельно следите за тем, чтобы ваш пароль не стал известен третьим лицам, а также самостоятельно своевременно изменяете его, если такое случится.</li>
    <li>Разработчики и администрация Системы не отвечают за содержание данных, созданных в Системе пользователями.</li>
    <li>Ваш аккаунт и подконтрольные вам данные в Системе могут быть в одностороннем порядке изменены и/или удалены администрацией Системы без предварительного уведомления и без объяснения причин.</li>
    <li>Вы обязуетесь использовать Систему штатным образом и не пытаться каким либо образом нарушить ее нормальное функционирование.</li>
    <li>Разработчики и администрация Системы не отвечают за какие-либо действия пользователей, прямо или косвенно связанные с использованием Системы.</li>
</ol>
<div class="warn">
    <p>
        Создавайте учетную запись только в том случае, если согласны со всеми положениями!
    </p>
</div>
<?php endif ?>

<div class="hr">
    <p>
        <?php echo $form->renderFormTag('register') ?>
        <?php echo render_form($form, 'Зарегистрироваться',  ''); ?>
        <?php echo '</form>' ?>
    </p>
</div>

<p>
    <span class="warn">Перед вводом пароля проверьте</span>:
</p>
<ul>
    <li>какой язык включен;</li>
    <li>выключен ли CAPS&nbsp;LOCK;</li>
    <li>в нужном ли состоянии NUM&nbsp;LOCK.</li>
</ul>
<p>
    <span class="warn">Настоятельно рекомендуется</span>, чтобы пароль удовлетворял следующим критериям:
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
<p>
    <span class="warn">Рекомендуется указывать действующий адрес электронной почты</span>, чтобы:
</p>
<ul>
    <li>была возможность активировать учетную запись;</li>
    <li>в дальнейшем можно было восстановить пароль.</li>
</ul>