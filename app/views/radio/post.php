<?php getHeader($data['header_data']); ?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1><?= $data['post_data']['post_title'] ?></h1>
  </div>
</div>

<section class="page-section">
    <div class="page-post">
        <?php echo $data['post']; ?>
    </div>
</section>

<?php getFooter($data['footer_data']); ?>
