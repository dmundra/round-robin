<?php
function round_robin($teams) {
  $rounds = array();
  foreach ($teams as $t1) {
    foreach ($teams as $t2) {
      if ($t1 != $t2 and !in_array("$t2-$t1", $rounds)) {
        $rounds[] = "$t1-$t2";
      }
    }
  }
  return $rounds;
}
$schedule = round_robin(array(1,2,3,4));
shuffle($schedule);

$all_games = array();
$storage = array();

function add(&$arr1, $arr2) {
  foreach ($arr2 as $a2) {
    if(!in_array($a2, $arr1)) {
      $arr1[] = $a2;
    }
  }
}

foreach($schedule AS $round) { 
  $split = preg_split('/-/', $round);
  $home = $split[0];
  $away = $split[1];
  //echo $home." - ".$away."\n";
  $game = "(".$home." - ".$away.")";
  $storage[$home][] = $game;
  $storage[$away][] = $game;
  add($storage[$home],$storage[$away]);
  add($storage[$away],$storage[$home]);
  $all_games[] = $game;
}
echo "Games:\n";
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
