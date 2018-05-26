<?php
$id = $data['id'];
$homeTeam = $data['home_team'];
$visitingTeam = $data['visiting_team'];
$date = $data['date'];
?>
<div class="game-data">
  <div class="next-game">
    <div class="next-game__actions">
      <h5>Next Game</h5>
      <a href="/schedule/<?= $id ?>" class="btn btn__primary btn__primary--dark">More Info</a>
      <a href="/schedule/<?= $id ?>#location" class="btn btn__primary btn__primary--dark location-btn">Location Map</a>
    </div>
    <div class="next-game__players">
      <div class="next-game__player1">
        <?= $homeTeam ?> <span class="next-game__vs">vs</span>
      </div>
      <div class="next-game__player2">
        <?= $visitingTeam ?>
      </div>
    </div>
  </div>
  <div class="game-countdown">
    <div class="game-countdown__date">
      <?= $date ?>
    </div>
    <div class="game-countdown__counter" data-gamedate="<?= $date ?>">
      <?php getComponent('CountdownTimer'); ?>
    </div>
  </div>
</div>
