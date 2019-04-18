<?php

echo "version: 2<br>";

// Seasons Update //
$dir = "data/seasons";
$file_to_write = "seasons.csv";
$content_to_write = "id,years,current,gamesPath\n1001,2018-2019,0,games.csv\n1002,2019-2020,1,seasons/games-2020.csv";
$gamesFile = "games-2020.csv";
$games2020Setup = "id,date,home_team,visiting_team,location,home_score,visiting_score";

if (is_dir($dir)) {
  echo "up to date...<br>";
} else {
  echo "adding seasons...<br>";
  mkdir($dir);
  if (is_dir($dir)) {
    echo "sesons dir created...<br>";
    $file = fopen($dir . '/' . $file_to_write,"w");
    fwrite($file, $content_to_write);
    fclose($file);
    include $dir . '/' . $file_to_write;
    $newfile = fopen($dir . '/' . $gamesFile, "w");
    fwrite($newfile, $games2020Setup);
    fclose($newfile);
    echo "<hr>";
    include $dir . '/' . $gamesFile;

  } else {
    echo "something went wrong...";
  }
}

// remove season date from schedule page data //
echo "...<br>";

function model($model)
{
  require_once 'app/models/'.$model.'.php';
  return new $model();
}

if(file_exists('data/pages/schedule.csv')) {
  echo "updating schedule page data...<br>";
  $pageModel = model('PageModel');
  $data = $pageModel->getPageData('schedule');
  $data[0]['page_title'] = 'Schedule';
  $pageModel->updatePageData('schedule', $data[0]);
  echo "<hr>";
  include 'data/pages/schedule.csv';
} else {
  echo "couldn't find schedule page data file...<br>";
}

echo "<hr>";
