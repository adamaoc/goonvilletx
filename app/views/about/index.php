<?php getHeader($data['header_data']); ?>

<div class="large-banner">
  <div class="large-banner__content">
    <h1><?= $data['page_data']['page_title'] ?></h1>
  </div>
</div>

<?php getComponent('AboutContent'); ?>


<?php getFooter($data['footer_data']); ?>
