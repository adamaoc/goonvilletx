<?php getHeader($data['header_data']); ?>
<div class="home-page">
  <div class="large-banner">
    <div class="large-banner__content">
      <h1>Goonville, TX</h1>
      <a href="/about" class="btn btn__banner">About Us</a>
    </div>
  </div>

  <?php getComponent('GameData', $data['game_data']); ?>

  <?php getComponent('AboutContent'); ?>

  <div class="innerpage-schedule">
    <div class="schedule-list">
      <h2>2018-2019 Schedule</h2>
      <?php getComponent('ScheduleList', $data['games']) ?>
    </div>
    <div class="schedule-list__more">
      <p>Check out more of the schedule and past results by clicking the button</p>
      <a href="/schedule" class="btn btn__primary">See More</a>
    </div>
  </div>

  <div class="innerpage-team">
    <?php getComponent('TeamsBlock'); ?>
  </div>

  <div class="innerpage-sponsors">
    <?php getComponent('Sponsors'); ?>
  </div>
</div>

<?php getFooter($data['footer_data']); ?>
