<?php getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1><?= $data['page_data']['page_title'] ?></h1>
  </div>
</div>

<div class="page-section">
  <iframe src="https://mixlr.com/users/6764389/embed" width="100%" height="180px" scrolling="no" frameborder="no" marginheight="0" marginwidth="0"></iframe>
  <small><a href="http://mixlr.com/goonvilletx" style="color:#1a1a1a;text-align:left; font-family:Helvetica, sans-serif; font-size:11px;">GoonvilleTX is on Mixlr</a></small>
</div>

<div class="page-section">

  <div class="standalone" id="app_download_dialog">
    <div class="desktop_app">
      <img alt="Desktop App" src="/public/images/mixlr/DesktopApp_Slide_HW640_2016.png">
      <h2>Download for desktop</h2>
      <h3>Broadcast and share live audio</h3>
      <p>Use up to 3 channels and mix audio between them. Connect to any audio source. Add a built-in or external mic. Create a playlist and take it live.</p>
      <p></p>
      <a class="landing_download" data-analytics-download="Windows" href="http://cdn.mixlr.com/MixlrInstaller.exe" id="download_windows_app">
        Download the Windows App
      </a>
      <a class="landing_download" data-analytics-download="Mac" href="http://cdn.mixlr.com/Mixlr.dmg" id="download_mac_app">
        Download the Mac App
      </a>
    </div>

    <div class="iPhone_app">
      <img alt="Desktop App" src="/public/images/mixlr/iPhone_App_SlidesAnimation_HW640.gif">
      <h2>Download for mobile / tablet</h2>
      <h3>Broadcast, share, chat, listen and explore.</h3>
      <p>Broadcast and share live audio simply and quickly directly from your mobile device. Listen with friends, &amp; chat with them.</p>
      <a data-analytics-download="Android" href="https://play.google.com/store/apps/details?id=com.mixlr.android" id="download_android_app" target="_blank">
        Download the Android App
      </a>
      <a data-analytics-download="iOS" href="https://itunes.apple.com/app/mixlr/id583705714" id="download_iphone_app" target="_blank">
        Download the iOS App
      </a>
    </div>
  </div>

</div>
<!-- <div class="page-coming-soon">
  <h2>Coming Soon...</h2>
</div> -->

<?php getFooter($data['footer_data']); ?>
