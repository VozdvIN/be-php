<h2>Вход</h2>

<?php include_partial('global/formSimple', array('form' => $form, 'url' => 'auth/login', 'commitLabel' => 'Войти')); ?>

<p>
	Если Вы здесь впервые, то сначала <?php echo link_to('зарегистрируйтесь', 'auth/register')?>.
</p>