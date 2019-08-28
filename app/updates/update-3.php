<?php

echo "version: 3<br>";

// Rosters Update //
$dir = "data/rosters/teams";
$file_to_write = "team.csv";
$content_to_write = "id,team,season\n1001,'varsity','2019-2020'\n1002,'jv','2019-2020'\n1003,'freshman','2019-2020'";

$teamsArr = array('varsity', 'jv', 'freshman');

// $rosterFile = "team-varsity.csv";
$teamsVarsitySetup = "id,name,jersey,position,class,grad_year,height,weight,school,img";

if (is_dir($dir)) {

  echo "up to date...<br>";

} else {

  echo "adding rosters...<br>";
  mkdir($dir);

  if (is_dir($dir)) {

    echo "teams dir created...<br>";
    $file = fopen($dir . '/' . $file_to_write,"w");
    fwrite($file, $content_to_write);
    fclose($file);
    include $dir . '/' . $file_to_write;

    foreach ($teamsArr as $team) {
      $rosterFile = 'team-' . $team . '.csv';
      $newfile = fopen($dir . '/' . $rosterFile, "w");
      fwrite($newfile, $teamsVarsitySetup);
      fclose($newfile);
      echo "<br> <hr>wrote - " . $team . "<br>";
      include $dir . '/' . $rosterFile;
      echo "<hr>";
    }

    



  } else {
    echo "something went wrong...";
  }

}