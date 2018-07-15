<?php getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1><?= $data['page_data']['page_title'] ?></h1>
  </div>
</div>

<div class="about__wrap">
  <?php getComponent('AboutContent'); ?>
  <section class="page-section">
    <h2>More about North Forney</h2>
    <p>The mission statement for our campus is</p>
    <p>“Finding our True North.”</p>
    <p>We will work to discover what it truly means to be a North Forney Falcon as we help students map out a path for their futures and instill in them the self-direction needed for them to succeed.</p>
  </section>
</div>

<?php getFooter($data['footer_data']); ?>
