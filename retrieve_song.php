<?php

include("php_functions.php"); 

$the_key = htmlspecialchars($_GET["key"]);
$the_title = htmlspecialchars($_GET["title"]);

// part 1 - gather data from database; make mysql calls

$servername = "fake_host";

$username = "fake_user";

$password = "fake_password"; 

$dbname = "fake_database";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// check connection
if ($conn->connect_error) {
  die("connection failed: " . $conn->connect_error);
}

$sql_q = "select * from song_test1 where full_name = '$the_title'\n"; 

$result = $conn->query($sql_q);

$resl = ""; 
$big_arr = array();
$inc = 1; 

if ($result->num_rows > 0) {
  $resl = 1; 

  // output data of each row
  while($row = $result->fetch_assoc()) {

    $small_arr = $row; 
    $big_arr[$inc] = $small_arr; 
    $inc++;
  }
} else {
  $resl = 0; 
}

$conn->close();

$output_str = "";
$this_arr = $big_arr[1];

// now - process the chords value using multiple explode commands
$chords_str = $this_arr["chords"];
$chords_arr1 = explode("|", $chords_str); 

$output_str .= "<h2>" . $this_arr["full_name"] . " in " . $the_key . "</h2>\n";
$output_str .= "<br>\n";

$output_str .= "<TABLE id=\"chords_table\" >\n";

$the_id = chord_to_id($the_key); 

foreach($chords_arr1 as $chords_2) {

  $output_str .= "<TR>\n"; 
  $chords_arr2 = explode(",", $chords_2); 
  foreach($chords_arr2 as $chords_3) {

    $output_str .= "<TD>\n";
    $chords_arr3 = explode(".", $chords_3); 
    $output_str .= "<TABLE class=\"chords_border\"><TR>";

    foreach($chords_arr3 as $each_chord) {
      if($each_chord == "_")
        $each_chord = "";
      else {
        $chord_id = substr($each_chord, 0, 1);
        $chord_type = substr($each_chord, 1, 1); 
        // look up chord_id

        $chord_id = $chord_id - 1; 
        $trans_chord = $the_id + $chord_id; 
        if($trans_chord > 11)
          $trans_chord = $trans_chord - 12; 
        $real_chord = id_to_chord($trans_chord); 
        $real_chord = desolve_flats($real_chord); 
        $each_chord = $real_chord; 
        // look up chord_type

      }
      $output_str .= "<TD class=\"chords_table\">" . $each_chord . "</TD>\n"; 
    }
    $output_str .= "</TR></TABLE>\n"; 

    $output_str .= "</TD>\n"; 
    
  }
  $output_str .= "</TR>\n"; 

}

$output_str .= "</TABLE>\n";

$output_str .= "<button onclick=\"return cancelAdding();\">Cancel</button> \n";
$output_str .= "<button onclick=\"return addChordLine();\">Add this Chord Line to Section</button> \n";

print $output_str . "\n"; 

###############################################
### Functions (Depreciated I believe)

function chord_to_id_old( $chord ) {

  $the_id = "";

  switch ($chord) {
    case "A":
        $the_id = 0; 
        //code to be executed if n=label1;
        break;
    case "H":
        $the_id = 1; 
        break; 
    case "B":
        $the_id = 2;
        break;
    case "C":
        $the_id = 3;
        break;
    case "I":
        $the_id = 4;
        break;
    case "D":
        $the_id = 5;
        break;
    case "J":
        $the_id = 6;
        break;
    case "E":
        $the_id = 7;
        break;
    case "F":
        $the_id = 8;
        break;
    case "K":
        $the_id = 9;
        break;
    case "G":
        $the_id = 10;
        break;
    case "L":
        $the_id = 11;
        break;
  }
  return $the_id; 
}


function id_to_chord_old( $id ) {

  $the_chord = "";

  switch ($id) {
    case 0:
        $the_chord = "A"; 
        //code to be executed if n=label1;
        break;
    case 1:
        $the_chord = "H"; 
        break; 
    case 2:
        $the_chord = "B";
        break;
    case 3:
        $the_chord = "C";
        break;
    case 4:
        $the_chord = "I";
        break;
    case 5:
        $the_chord = "D";
        break;
    case 6:
        $the_chord = "J";
        break;
    case 7:
        $the_chord = "E";
        break;
    case 8:
        $the_chord = "F";
        break;
    case 9:
        $the_chord = "K";
        break;
    case 10:
        $the_chord = "G";
        break;
    case 11:
        $the_chord = "L";
        break;
  }
  return $the_chord; 
}

function resolve_flats_old($raw_chord) {
  $smooth_chord = "";

  switch ($raw_chord) {
    case "Bb":
        $smooth_chord = "H";
        //code to be executed if n=label1;
        break;
    case "C#":
        $smooth_chord = "I";
        break;
    case "Eb":
        $smooth_chord = "J";
        break;
    case "F#":
        $smooth_chord = "K";
        break;
    case "Ab":
        $smooth_chord = "L";
        break;
    default:
        $smooth_chord = $raw_chord; 
  }
  return $smooth_chord; 
}

function desolve_flats_old($smooth_chord) {
  $raw_chord = "";

  switch ($smooth_chord) {
    case "H":
        $raw_chord = "Bb";
        //code to be executed if n=label1;
        break;
    case "I":
        $raw_chord = "C#";
        break;
    case "J":
        $raw_chord = "Eb";
        break;
    case "K":
        $raw_chord = "F#";
        break;
    case "L":
        $raw_chord = "Ab";
        break;
    default:
        $raw_chord = $smooth_chord;
  }
  return $raw_chord; 
}


?>
