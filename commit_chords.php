<?php

include("php_functions.php");
// setting this variables in stone for now


$song_id = htmlspecialchars($_GET["song"]);
$chord_string = htmlspecialchars($_GET["chord_string"]);
$song_section = htmlspecialchars($_GET["section"]);


/*
// using JoJo (id=19) as a placeholder
$song_id = 19; 
$chord_string="FQ._Q.CQ._Q,EQ._U.FQ._Q,FQ._Q._Q._Q,_Q._Q._Q._Q,";
$song_section = "A";
*/

$key_query = "SELECT base_key from song_table WHERE id = '$song_id'";

$razl = query_database($key_query);

$basekey = $razl["base_key"];

// remove trailing period
$smooth_str = substr($chord_string, 0, -1);

$meas_arr = explode(",", $smooth_str);

$base_id = chord_to_id( $basekey );
$interval = $base_id - 1;

$result_str = "";

foreach($meas_arr as $messy) {

  $beat_arr = explode(".", $messy);
  foreach($beat_arr as $beatty) {
    $c_val = substr($beatty, 0, 1);
    $c_typ = substr($beatty, 1, 1);
    $right_id = chords_to_key($c_val, $interval);
    $result_str .= $right_id . $c_typ . ".";
  }
  $result_str = substr($result_str, 0, -1);
  $result_str .= ",";

}

$result_str = substr($result_str, 0, -1);

// prepare the SQL query
$query = "INSERT INTO chords_table(song_id, section, chord_string) VALUES ($song_id, '$song_section', \"$result_str\")";

$resl = insert_to_db($query);

if($resl != true) {
  print "Something went wrong running the insert query...\n";
  exit;
}

print "QUERY submitted successfully - $query \n";


function chords_to_key( $one_chord, $interval ) {
  if($one_chord === '_') 
    return '_';
  $cid = chord_to_id ($one_chord);
  $correct_id = $cid - $interval;
  if($correct_id < 1)
    $correct_id = $correct_id + 12; 
  return $correct_id; 
}


function convert_chords_to_key( $basekey, $one_chord) {

  // determine the interval difference
  $base_id = chord_to_id( $basekey );
  $interval = $base_id - 1; 

  

}

?>
