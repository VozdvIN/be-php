<?php
render_breadcombs(array(
    link_to('Участники', 'webUser/index'),
    link_to($form->getObject()->WebUser->login, 'webUser/show?id='.$form->getObject()->web_user_id),
));
?>

<h2>Новое право или запрет для &quot;<?php echo $form->getObject()->WebUser->login ?>&quot;</h2>

<?php include_partial('global/formCrud', array('form' => $form, 'module' => 'grantedPermission')); ?>