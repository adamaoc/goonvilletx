<ul>
  <?php
    if (!empty($data)) :
      foreach ($data as $key => $game) : ?>
      <li>
        <span class="schedule-list__date">
          <?= $game['date'] ?>
        </span>
        <span class="schedule-list__teams">
          <?= $game['home_team'] ?> vs <?= $game['visiting_team'] ?>
        </span>
      </li>
    <?php endforeach; ?>
  <?php else: ?>
    <li><h3>- No Events</h3></li>
  <?php endif; ?>
</ul>
