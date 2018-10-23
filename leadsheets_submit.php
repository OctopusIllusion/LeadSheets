<?php

include("php_functions.php");

$songtitle = $_POST["songtitle"];
$songkey = $_POST["songkey"];
$chordtype = $_POST["chordtype"];
$n_sections = $_POST["songsections"];

$key_val = "";
if( strcmp($chordtype,"major") == 0)
  $key_val = 1;
else
  $key_val = 0; 

$fresh_q = "INSERT INTO song_table(title, is_major, base_key, sections) VALUES('$songtitle', $key_val, '$songkey', $n_sections)"; 

$resl = insert_to_db($fresh_q); 

if($resl != true) {
  print "Something went wrong running the insert query...\n"; 
  print $fresh_q . "\n"; 
  exit; 
}

// otherwise the insert worked! 
// Run a follow-up query to get the most recently submitted id
$id_quer = "SELECT id FROM song_table WHERE title = '$songtitle' ORDER BY id DESC limit 1";

$razl = query_database($id_quer); 

$new_id = $razl["id"];

print $new_id; 

?>
