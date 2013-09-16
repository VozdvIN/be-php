<?php
render_breadcombs(array(
    link_to('Модерирование', 'moderation/show'),
    link_to('Проекты', 'region/index', array('confirm' => 'Вернуться без сохранения?'))
    ))
?>

<h2>Правка проекта</h2>
<?php include_partial('form', array('form' => $form)) ?>
