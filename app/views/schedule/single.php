<?php
  getHeader($data['header_data']);
  $game = $data['gameData'];
  $postData = $data['postData'];
  $hasPost = false;
  if (!is_null($postData) && $postData['status'] === 'published') {
    $hasPost = true;
  }
?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1><?= $game['home_team'] ?> vs <?= $game['visiting_team'] ?></h1>
    <div class="mid-banner__meta">
      <span>Date:</span> <?= $game['date']; ?> <br>
      <span>Location:</span> <?= $game['location'] ?>
    </div>
  </div>
</div>

<div class="game-page">

  <?php if ($hasPost) {
    echo "<h2>" . $postData['title'] . "</h2>";
    echo "<p><meta>by: " . $postData['author'] . "</meta></p>";
  } else {
    echo "<h2>The Game</h2><p>More info on the game coming soon...</p>";
  }
  ?>

  <?php if ($hasPost) {
    echo "<hr />";
    echo $data['postData']['content'];
  } ?>

</div>


<?php getFooter($data['footer_data']); ?>
