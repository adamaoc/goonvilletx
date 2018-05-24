<?php getHeader($data['header_data']); ?>

<div class="large-banner">
  <div class="large-banner__content">
    <h1>2018-2019 Schedule</h1>
  </div>
</div>

<div class="innerpage-schedule">
  <div class="schedule-list">
    <h2>2018-2019 Schedule</h2>
    <?php getComponent('ScheduleList', $data['games']) ?>
  </div>
</div>


<div class="innerpage-schedule">
  <div class="schedule-list">
    <h2>Game Results</h2>
    <?php getComponent('ScheduleList', $data['past_games']) ?>
  </div>
</div>


<?php getFooter($data['footer_data']); ?>
