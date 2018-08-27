<?php getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1>Polish & Pray</h1>
  </div>
</div>

<div class="about__wrap">
  <section class="page-section center">
    <img src="/public/images/pages/pnp/banner.jpg" alt="Polish and Pray banner." />
  </section>
  <section class="page-section">
    <h2>About Polish and Pray</h2>
    <p>The day before the game we like to gather together and as moms, to pray for our boys. We also take the time to clean up their lockers and leave them notes or treats to find the day of their games.</p>
    <p>This is a great thing for the kids and a great bonding time for moms of Goonville, TX.</p>
  </section>
  <section class="page-section">
    <h2>Schedule</h2>
    <h3>Varsity Moms</h3>
    <p>Thursday nights at 8:00pm</p>
    <h3>JV Moms</h3>
    <p>Wednesday nights at 7:00pm</p>
    <h3>Freshman Moms</h3>
    <p>Wednesday nights at 7:00pm</p>
  </section>
  <section class="page-section">
    <h2>Image Gallery</h2>
    <?php getComponent('imgGallery', array('folder' => 'pages/pnp')); ?>
  </section>
</div>

<?php getFooter($data['footer_data']); ?>
