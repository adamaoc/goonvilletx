<?php
  $schema = array(
    "block_name" => "header_banner",
    "block_label" => "Header Banner",
    "header" => array(
      "name" => "title",
      "label" => "Banner Header",
      "type" => "text",
      "default" => "Goonville, TX"
    ),
    "action" => array(
      "name" => "action",
      "class" => "btn btn__banner",
      "type" => "link",
      "action_text" => array(
        "name" => "header_action_text",
        "label" => "Banner Action Button Text",
        "type" => "text"
      ),
      "action_link" => array(
        "name" => "header_action_link",
        "label" => "Banner Action Button Link",
        "type" => "text"
      )
    )
  );
?>

<div class="large-banner">
  <div class="large-banner__content">
    <?php editableBlock($schema['header'], 'h1', $data['page']); ?>
    <?php editableBlock($schema['action'], 'a', $data['page']); ?>
  </div>
</div>
