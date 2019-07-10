<ul class="new-schedule-list">
  <?php
    if (!empty($data)) :
      foreach ($data as $key => $game) : ?>
      <li class="new-schedule-list--item">
        <div class="new-schedule-list--date">
          <?php 
            $new_date = date('M d Y', strtotime($game['date']));  
            echo $new_date;
          ?>
        </div>
        <div class="new-schedule-list--teams">
          <span><?= $game['home_team'] ?></span> 
          <span>vs</span>
          <span><?= $game['visiting_team'] ?></span>
        </div>
      </li>
    <?php endforeach; ?>
  <?php else: ?>
    <li><h3>- No Events</h3></li>
  <?php endif; ?>
</ul>
