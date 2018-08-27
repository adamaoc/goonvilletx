<?php getHeader($data['header_data']); ?>
<div class="home-page">
  <div class="large-banner">
    <div class="large-banner__content">
      <h1><?= $data['page_data']['page_title'] ?></h1>
      <div class="btn-group">
        <a href="/<?= $data['page_data']['action_btn_link'] ?>" class="btn btn__banner"><?= $data['page_data']['action_btn_text'] ?></a>
        <button class="btn btn__banner btn__mixlr" id="listenBtn">
          <svg width="30px" height="30px" viewBox="0 0 300 300">
            <circle id="Oval-4" stroke="#ED1C24" stroke-width="8" cx="150" cy="150" r="137.769531"></circle>
            <polygon id="Triangle" fill="#ED1C24" transform="translate(167.000000, 150.000000) rotate(90.000000) translate(-167.000000, -150.000000) " points="167 102.978516 229.576172 197.021484 104.423828 197.021484"></polygon>
          </svg>
          Listen to the game!
        </button>
      </div>
    </div>
  </div>

  <?php getComponent('GameData', $data['game_data']); ?>

  <?php
    if (!empty($data['announcement'])) {
      getComponent('Announcements', $data['announcement']);
    }
  ?>

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

  <section class="page-section center">
    <a href="/page/polish-and-pray/">
      <img src="/public/images/pages/pnp/banner.jpg" alt="Polish and Pray banner." />
    </a>
  </section>

  <div class="innerpage-sponsors">
    <?php getComponent('Sponsors', $data['sponsors']); ?>
  </div>
</div>

<?php if (Config::get('http/root') === 'http://goonvilletx.com/') : ?>
  <div class="player-modal" style="display: none;">
    <div class="player-modal__box">
      <button id="closeModal">
        <svg width="30px" height="30px" viewBox="0 0 50 50">
          <circle id="Oval-3" fill="#313131" cx="25" cy="25" r="21.5"></circle>
          <polygon id="x" fill="#FFFFFF" points="11.8408203 38.28125 20.9228516 24.8046875 12.2314453 11.71875 20.7519531 11.71875 25.1953125 19.4335938 29.5410156 11.71875 37.8173828 11.71875 29.0771484 24.6826172 38.1591797 38.28125 29.4921875 38.28125 24.9023438 30.2978516 20.2880859 38.28125"></polygon>
        </svg>
      </button>
      <iframe src="https://mixlr.com/users/6764389/embed" width="100%" height="180px" scrolling="no" frameborder="no" marginheight="0" marginwidth="0"></iframe>
      <small><a href="/radio" style="color:#1a1a1a;text-align:left; font-family:Helvetica, sans-serif; font-size:11px;">Learn more about Goonville Radio.</a></small>
    </div>
  </div>
<?php endif; ?>

<?php getFooter($data['footer_data']); ?>
