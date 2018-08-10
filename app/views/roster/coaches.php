<?php
$coaches = $data['roster'];

getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1>2018-2019 Coaches</h1>
  </div>
</div>

<div class="roster-page">
  <?php if (count($coaches) > 0) : ?>
    <div class="coach-list">
    <?php foreach ($coaches as $coach) : ?>
      <div class="coach-list__item">
        <div class="coach-list__wrap">
          <div class="coach-list__img" style="background-image: url(/data/rosters/imgs/<?= $coach['photo'] ?>)"></div>
          <div class="coach-list__stats">
            <div><label>Name: </label> <?= $coach['name'] ?></div>
            <div><label>Title: </label> <?= $coach['title'] ?></div>
            <div class="coach-list__bio">
              <?= $coach['bio'] ?>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<div class="innerpage-team">
  <?php getComponent('TeamsBlock'); ?>
</div>

<?php getFooter($data['footer_data']); ?>
