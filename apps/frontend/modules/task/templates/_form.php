<?php include_partial('global/formHeadCrud', array('form' => $form, 'module' => 'task')); ?>

<tr><td colspan="3"><h4>Основные</h4></td></tr>
<?php include_partial('global/formField', array('field' => $form['name'])); ?>
<?php include_partial('global/formField', array('field' => $form['public_name'])); ?>
<?php include_partial('global/formField', array('field' => $form['time_per_task_local'])); ?>
<?php include_partial('global/formField', array('field' => $form['try_count_local'])); ?>
<?php include_partial('global/formField', array('field' => $form['min_answers_to_success'])); ?>
<tr><td colspan="3"><h4>Управление</h4></td></tr>
<?php include_partial('global/formField', array('field' => $form['max_teams'])); ?>
<?php include_partial('global/formField', array('field' => $form['manual_start'])); ?>
<?php include_partial('global/formField', array('field' => $form['locked'])); ?>
<tr><td colspan="3"><h4>Приоритеты</h4></td></tr>
<?php include_partial('global/formField', array('field' => $form['priority_free'])); ?>
<?php include_partial('global/formField', array('field' => $form['priority_busy'])); ?>
<?php include_partial('global/formField', array('field' => $form['priority_filled'])); ?>
<?php include_partial('global/formField', array('field' => $form['priority_per_team'])); ?>

<?php include_partial('global/formFoot', array('form' => $form, 'commitLabel' => (($form->getObject()->isNew()) ? 'Создать' : 'Сохранить'))); ?>