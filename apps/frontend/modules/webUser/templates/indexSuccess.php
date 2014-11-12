<?php render_breadcombs(array('Участники')); ?>

<h2>Участники</h2>

<ul>
  <?php foreach ($_webUsers as $webUser): ?>
  <li>
    <div class="<?php
                if ($webUser->id == $_sessionWebUserId) { echo 'info'; }
                elseif (!$webUser->is_enabled) { echo 'warn'; }
                else echo 'indent';
                ?>">
      <?php
      echo link_to($webUser->login, url_for('webUser/show?id='.$webUser->id));
      echo ($webUser->full_name !== '') ? ', '.$webUser->full_name : '';
      echo ($webUser->id == $_sessionWebUserId) ? ' - это Вы' : '';
      echo (!$webUser->is_enabled) ? ' - блокирован' : '';
      ?>
    </div>
  </li>
  <?php endforeach; ?>
</ul>