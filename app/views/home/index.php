<?php getHeader($data['header_data']); ?>

<div class="large-banner">
  <div class="large-banner__content">
    <h1>Goonville, TX</h1>
    <a href="/about" class="btn btn__banner">About Us</a>
  </div>
</div>

<?php getComponent('GameData'); ?>

<?php getComponent('AboutContent'); ?>

<div class="innerpage-schedule">
  <?php getComponent('ScheduleList') ?>
</div>

<div class="innerpage-team">
  <?php getComponent('TeamsBlock'); ?>
</div>

<div class="innerpage-sponsors">
  <?php getComponent('Sponsors'); ?>
</div>

<?php getFooter(); ?>
