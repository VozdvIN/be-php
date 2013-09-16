<?php
render_breadcombs(array(
    link_to('Модерирование', 'moderation/show'),
    link_to('Игровые проекты', 'region/index')
    ))
?>

<h2>Новый игровой проект</h2>
<?php include_partial('form', array('form' => $form)) ?>
