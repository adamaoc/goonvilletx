<?php getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1><?= $data['page_data']['page_title'] ?></h1>
  </div>
</div>

<section class="schedule-page__wrap">
  <div class="innerpage-schedule">
    <div class="schedule-list">
      <h2>2018-2019 Schedule</h2>
      <?php getComponent('ScheduleList', $data['games']); ?>
    </div>
  </div>


  <div class="innerpage-schedule">
    <div class="schedule-list">
      <h2>Game Results</h2>
      <?php getComponent('GameResults', $data['past_games']); ?>
    </div>
  </div>
</section>

<?php getFooter($data['footer_data']); ?>
