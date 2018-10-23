<?php

include("php_functions.php");

$the_id = htmlspecialchars($_GET["id"]);

$key_query = "SELECT base_key from song_table WHERE id = '$the_id'";

$razl = query_database($key_query);

$basekey = $razl["base_key"];

$the_int = get_select_int($basekey);

print $the_int; 


function get_select_int( $baskey ) {
  $resp = -1;
  switch ($baskey) {
    case 'A':
      $resp = 0;
      break;
    case 'H':
      $resp = 1;
      break; 
    case 'B':
      $resp = 2;
      break;
    case 'C':
      $resp = 3;
      break;
    case 'I':
      $resp = 4;
      break;
    case 'D':
      $resp = 5;
      break;
    case 'J':
      $resp = 6;
      break;
    case 'E':
      $resp = 7;
      break;
    case 'F':
      $resp = 8;
      break;
    case 'K':
      $resp = 9;
      break;
    case 'G':
      $resp = 10;
      break;
    case 'L':
      $resp = 11;
      break;
  }
  return $resp;
}


?>
