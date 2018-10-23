<?php

include("php_functions.php"); 

$the_key = htmlspecialchars($_GET["key"]);
// the_title is actually the id, a mistake
$the_title = htmlspecialchars($_GET["title"]);

$q1 = "SELECT title, sections, is_major, structure FROM song_table WHERE id = '$the_title'"; 

$result = query_database($q1);

$real_title = $result["title"]; 
$real_sections = $result["sections"];
$major = $result["is_major"];
$song_structure = $result["structure"];

$output_str = "";

$spec_key = desolve_flats($the_key); 

if($major == 0)
  $output_str .= "<div class=\"song_title\">" . $real_title . " in " . $spec_key . "min</div>\n";
else
  $output_str .= "<div class=\"song_title\">" . $real_title . " in " . $spec_key . "</div>\n";

if($real_sections == 1) {

  $query = "SELECT chord_string FROM chords_table WHERE song_id = '$the_title' ORDER BY c_id";

  $resl = big_query($query);

  if($resl != true) {
    print "Something went wrong running the insert query...\n";
    exit;
  }
  if($resl == "NADA") {
    print "<div>No Results found, song not defined in Database</div><br>\n";
    print "<button onclick=\"return editChords( $the_title );\">Edit</button> \n";
    exit; 
  }

  $full_str = "";

  foreach($resl as $razl) {
    $full_str .= $razl["chord_string"] . "|";
  }

  $chords_str = substr($full_str, 0, -1);


// create a function from here on - only param is the "chord_string"

  $output_str .= chord_printout($chords_str, $the_key, ""); 

  $output_str .= "<br>\n";

}

else {

  if($real_sections == 2) 
    $sect_array = array('A', 'B');
  // else - must be 3 (app doesn't support more than 3 sections currently
  else 
    $sect_array = array('A', 'B', 'C');

  foreach($sect_array as $secty) {
    $full_str = ""; 

    $query = "SELECT chord_string FROM chords_table WHERE song_id = '$the_title' AND section = '$secty' ORDER BY c_id ";

    $resl = big_query($query);

    if($resl != true) {
      print "Something went wrong running the insert query...\n";
      exit;
    }
    if($resl == "NADA") {
      $response_s =  "<p>SECTION $secty not defined in Database.</p>\n";
      //exit;
      $output_str .= $response_s; 
    } else {

      foreach($resl as $razl) {
        $full_str .= $razl["chord_string"] . "|";
      }

      $chords_str = substr($full_str, 0, -1);

      $output_str .= chord_printout($chords_str, $the_key, $secty);

    }

    $output_str .= "<br>\n"; 
  }

}

if($song_structure != "")
  $output_str .= "<div class=\"s_structure\">Song Structure: $song_structure </div><br>\n";

$output_str .= "<button onclick=\"return editChords( $the_title );\">Edit</button> \n";

print $output_str . "\n";

###############################################3
### Functions

function chord_printout( $chords_str, $the_key, $section ) {

  $output_str = "";

  $chords_arr1 = explode("|", $chords_str); 

  $output_str .= "<TABLE id=\"chords_table\" >\n";

  if($section !== "") {
    $output_str .= "<CAPTION>$section SECTION</CAPTION>\n"; 
  }

  $the_id = chord_to_id($the_key); 

  $last_id = "";
  $last_type = "";

  foreach($chords_arr1 as $chords_2) {

    $output_str .= "<TR>\n"; 
    $chords_arr2 = explode(",", $chords_2); 
    foreach($chords_arr2 as $chords_3) {

      $output_str .= "<TD>\n";
      $chords_arr3 = explode(".", $chords_3); 
      $output_str .= "<TABLE class=\"chords_border\"><TR>";

      $first_tim = 1;
      foreach($chords_arr3 as $each_chord) {
        if(strlen($each_chord) == 3) {
          $chord_id = substr($each_chord, 0, 2);
          $chord_type = substr($each_chord, 2, 1);
        } else {
          $chord_id = substr($each_chord, 0, 1);
          $chord_type = substr($each_chord, 1, 1); 
        }
        if($chord_id == "_") {
          if($first_tim == 1) {
            $chord_id = $last_id;
            $chord_type = $last_type;
            $real_chord = id_to_chord($trans_chord);
            $real_chord = desolve_flats($real_chord);
            $chord_suf = type_lookup($chord_type);
            $each_chord = $real_chord . $chord_suf; 
            $first_tim = 0;
          } else
            $each_chord = "";
        } else {
          // save last id, type
          $last_id = $chord_id;
          $last_type = $chord_type;
          // look up chord_id

          $chord_id = $chord_id - 1; 
          $trans_chord = $the_id + $chord_id; 
          if($trans_chord > 11)
            $trans_chord = $trans_chord - 12; 
          $real_chord = id_to_chord($trans_chord); 
          $real_chord = desolve_flats($real_chord); 
          $each_chord = $real_chord; 
          // look up chord_type
          $chord_suffix = type_lookup($chord_type);
          $each_chord = $real_chord . $chord_suffix;

        }
        $output_str .= "<TD class=\"one_beat\">" . $each_chord . "</TD>\n"; 
        $first_tim = 0;
      }
      $output_str .= "</TR></TABLE>\n"; 

      $output_str .= "</TD>\n"; 
    
    }
    $output_str .= "</TR>\n"; 

  }

  $output_str .= "</TABLE>\n";

  return $output_str;
}

# Rest of functions are depreciated

function type_lookup_old( $type ) {
  $the_answer = "";
  switch ($type) {
    case "Q":
      $the_answer = "";
      break;
    case "R":
      $the_answer = "min";
      break; 
    case "S":
      $the_answer = "maj7";
      break;
    case "T":
      $the_answer = "min7";
      break;
    case "U":
      $the_answer = "7";
      break;
    case "V":
      $the_answer = "alt7";
      break;
    case "W":
      $the_answer = "dim";
      break;
    case "X":
      $the_answer = "1/2dim";
      break;
    case "Y":
      $the_answer = "aug";
      break;
    case "Z":
      $the_answer = "sus";
      break;
  
  }
  return $the_answer; 
}

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
