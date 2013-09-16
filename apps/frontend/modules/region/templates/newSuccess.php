<?php
render_breadcombs(array(
    link_to('Модерирование', 'moderation/show'),
    link_to('Проекты', 'region/index')
    ))
?>

<h2>Новый регион</h2>
<?php include_partial('form', array('form' => $form)) ?>
