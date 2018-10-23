<?php

include("php_functions.php");

$song_id = htmlspecialchars($_GET["songid"]);
$structure = htmlspecialchars($_GET["structure"]);

$query = "UPDATE song_table SET structure = \"$structure\" WHERE id = '$song_id'";

$resl = insert_to_db($query);

if($resl != true) {
  print "Something went wrong running the insert query...\n";
  exit;
}

print "QUERY submitted successfully - $query \n";

?>
