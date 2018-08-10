<?php
$players = $data['roster'];

getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1>2018-2019 Player Rosters</h1>
  </div>
</div>

<div class="roster-page">
  <?php if (count($players) > 0) : ?>
    <?php foreach ($players as $player) : ?>
      <?php $imgAlt = "{$player['name']} #{$player['number']}, {$player['positions']} at North Forney"; ?>
      <div class="roster-card">
        <div class="roster-card__img">
          <img src="/data/rosters/imgs/<?= $player['photo'] ?>" alt="<?= $imgAlt ?>" />
        </div>
        <div class="roster-card__stats">
          <div class="roster-card__name"><?= $player['name'] ?> #<?= $player['number'] ?></div>
          <div class="roster-card__stats-data">Position(s): <?= $player['positions'] ?></div>
          <div class="roster-card__stats-data">Grade: <?= $player['grade'] ?></div>
          <?php if (!empty($player['awards'])) : ?>
            <p><?= $player['awards'] ?></p>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php getFooter($data['footer_data']); ?>
