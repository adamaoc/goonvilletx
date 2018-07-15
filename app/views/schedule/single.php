<?php
  getHeader($data['header_data']);
  $game = $data['gameData'];
?>

<div class="mid-banner">
  <div class="mid-banner__content">
    <h1>The Game</h1>
    <p><?= $game['date']; ?></p>
  </div>
</div>

<div class="game-page">

  <h2><?= $game['home_team'] ?> vs <?= $game['visiting_team'] ?></h2>
  <p>More info coming soon...</p>
  <h3 id="location">Location:</h3>
  <?= $game['location'] ?>
</div>


<?php getFooter($data['footer_data']); ?>
