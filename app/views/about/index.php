<?php getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1><?= $data['page_data']['page_title'] ?></h1>
  </div>
</div>

<div class="about__wrap">
  <?php getComponent('AboutContent'); ?>
  
  <span id="in-the-know" style="position: absolute; top: 590px;"></span>
  <section class="page-section">
      <h2>Be in the Know!</h2>
      <p>While following our social media pages is a great way to keep up with what's going on in Goonville, if you really want to be in the know, you'll want to get in our WhatsApp chat!</p>
      <p style="text-align:center;"><em>Scan the QR-Code with your phone after downloading WhatsApp</em></p>
      <div style="display: flex; max-width: 800px; align-items:center; justify-content:center;">
        <a  title="Download WhatsApp from the App Store" href="https://apps.apple.com/us/app/whatsapp-messenger/id310633997" target="_blank">
          <img src="/public/images/innerpage/whatsApp.png" width="190px" alt="WhatsApp Logo" />
        </a>
        <a href="https://chat.whatsapp.com/invite/79sDLgBhygPHGddekm24RB" target="_blank" title="Scan Code with your Phone or Click">
          <img src="/public/images/innerpage/Goonville-WhatsApp-QR-img.jpg" alt="QR Code" width="150px" />
        </a>
      </div>
  </section>
  <section class="page-section center">
    <img src="/public/images/banners/what-is-goon.jpg" alt="What is a GOON?" />
  </section>
  <section class="page-section">
    <h2>More about North Forney</h2>
    <p>The mission statement for our campus is</p>
    <p>“Finding our True North.”</p>
    <p>We will work to discover what it truly means to be a North Forney Falcon as we help students map out a path for their futures and instill in them the self-direction needed for them to succeed.</p>
  </section>
</div>

<?php getFooter($data['footer_data']); ?>
