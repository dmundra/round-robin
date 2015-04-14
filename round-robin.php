<?php

/**
 * @author D.D.M. van Zelst
 * @copyright 2012
 */

function scheduler($teams){
  // Check for even number or add a bye
  if (count($teams)%2 != 0){
    array_push($teams,"bye");
  }
  // Splitting the teams array into two arrays
  $away = array_splice($teams,(count($teams)/2));
  $home = $teams;
  // The actual scheduling based on round robin
  for ($i=0; $i < count($home)+count($away)-1; $i++){
    for ($j=0; $j<count($home); $j++){
      $round[$i][$j]["Home"]=$home[$j];
      $round[$i][$j]["Away"]=$away[$j];
    }
    // Check if total numbers of teams is > 2 otherwise shifting the arrays is not neccesary
    if(count($home)+count($away)-1 > 2){
      $array_splice = array_splice($home,1,1);
      array_unshift($away,array_shift($array_splice));
      array_push($home,array_pop($away));
    }
  }
  return $round;
}

$members = array(1,2,3,4);
$all_games = array();
$storage = array();
$schedule = scheduler($members);

function add(&$arr1, $arr2) {
  foreach ($arr2 as $a2) {
    if(!in_array($a2, $arr1)) {
      $arr1[] = $a2;
    }
  }
}

foreach($schedule AS $round => $games){
  echo "Round: ".($round+1)."\n";
  foreach($games AS $play){
    $home = $play["Home"];
    $away = $play["Away"];
    echo $home." - ".$away."\n";
    if ($home != "bye" and $away != "bye") {
      $game = "(".$home." - ".$away.")";
      $storage[$home][] = $game;
      $storage[$away][] = $game;
      add($storage[$home],$storage[$away]);
      add($storage[$away],$storage[$home]);
      $all_games[] = $game;
    }
  }
  echo "\n";
}

echo "\nGames:\n";
print_r($all_games);
echo "Storage:\n";
print_r($storage);
echo "Missing:\n";
foreach ($storage as $team => $games) {
  echo "$team:\n";
  $diff = array_diff($all_games, $games);
  print_r($diff);
}
?>
