<ul>
  <?php
    if (!empty($data)) :
      foreach ($data as $key => $game) : ?>
      <li>
        <a href="/schedule/<?= $game['id'] ?>" class="schedule-list__icon">
          <?php getComponent('LinkIcon'); ?>
        </a>
        <span class="schedule-list__date">
          <?php 
            $new_date = date('M d Y', strtotime($game['date']));  
            echo $new_date;
          ?>
        </span>
        <span class="schedule-list__teams">
          <?= $game['home_team'] ?> (<?= $game['home_score'] ?>) vs <?= $game['visiting_team'] ?> (<?= $game['visiting_score'] ?>)
        </span>
      </li>
    <?php endforeach; ?>
  <?php else: ?>
    <li><h3>- No Events</h3></li>
  <?php endif; ?>
</ul>
