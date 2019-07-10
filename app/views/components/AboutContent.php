<?php 
  $hasBtn = false; 
  if ($data && $data['btn']) {
    $hasBtn = true;
  }

?>
<div class="innerpage-about">
  <div class="innerpage-about__content">
    <h2>
      <span class="header-sup">Goonville</span>
      Welcome to the home of the Falcons
    </h2>
    <p>We are the North Forney Falcons from Forney, TX - better known as Goonville, Texas.</p>
    <?php 
      if ($hasBtn) {
        echo '<p><a href="/about/#in-the-know" class="btn btn__banner">Be in the Know!</a></p>';
      }
    ?>
  </div>
</div>
