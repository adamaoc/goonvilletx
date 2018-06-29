<?php

  $schema = array(
    "header" => array(
      "name" => "header",
      "label" => "Header",
      "type" => "text"
    ),
    "excerpt" => array(
      "name" => "excerpt",
      "label" => "About Excerpt",
      "type" => "textbox"
    )
  );

?>

<div class="innerpage-about">
  <div class="innerpage-about__content">
    <h2>
      <span class="header-sup">Goonville</span>
      <?php editableBlock($schema['header'], 'span', 'about'); ?>
    </h2>
    <?php editableBlock($schema['excerpt'], 'p', 'about'); ?>
    <!-- <a href="/story" class="btn btn__secondary">Our Story</a> -->
  </div>
</div>
