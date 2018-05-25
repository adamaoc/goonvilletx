<ul>
  <?php
    if (!empty($data)) :
      foreach ($data as $key => $game) : ?>
      <li>
        <a href="/schedule/<?= $game['id'] ?>" class="schedule-list__icon">
          <?php getComponent('LinkIcon'); ?>
        </a>
        <span class="schedule-list__date"><?= $game['date'] ?></span>
        <span class="schedule-list__teams">
          <?= $game['home_team'] ?> vs <?= $game['visiting_team'] ?>
        </span>
      </li>
    <?php endforeach; ?>
  <?php endif; ?>
</ul>
