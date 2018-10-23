<?php

// setting this variables in stone for now

$beats_per_measure = htmlspecialchars($_GET["beats_pm"]);
$measures_per_row = htmlspecialchars($_GET["measures_pl"]);
$song_section = htmlspecialchars($_GET["section"]);
$key_type = htmlspecialchars($_GET["keytype"]);

//$beats_per_measure = 4;  
//$measures_per_row = 4; 

$output = "<br>\n"; 
$output .= "<fieldset>\n"; 
$output .= "<legend>New Row</legend>\n";
$output .= "<table class=\"template_table\"> \n"; 

$inc = 1; 
$ike = 1; 

$output .= "<tr class=\"template_table\">\n";


while($inc <= $measures_per_row) {

  // will need another while here, to iterate through the beats per measure
  $output .= "<td class=\"template_table\">\n";

  $itt = 1;


  $output .= "<table class=\"measure\"><tr class=\"template_table\" id=\"measure_$inc\">\n"; 

  while($itt <= $beats_per_measure) {

    $output .= "<td id=\"beat_$ike\">\n";

    if($key_type == "Flats") 
      $in_cell = print_cell_selectors_flats( $ike );
    else
      $in_cell = print_cell_selectors_sharps( $ike );
    $output .= $in_cell;

    $output .= "</td>\n";
    $itt++; 
    $ike++;

  }

  $output .= "</tr></table>\n";

  $output .= "</td>\n"; 

  $inc++;
}


$output .= "</tr>\n"; 

$output .= "</table>
<br>
<button onclick=\"return cancelAdding();\">Cancel</button>
<button onclick=\"return clearLine();\">Clear</button>
<button onclick=\"return addChordLine();\">Add this Chord Line to Section</button>";
$output .= "</fieldset>";
$output .= "<input type=\"hidden\" id=\"number_of_beats\" value=\"$ike\">";
$output .= "<input type=\"hidden\" id=\"beats_per_measure\" value=\"$beats_per_measure\">";
$output .= "<input type=\"hidden\" id=\"measures_per_row\" value=\"$measures_per_row\">";
$output .= "<input type=\"hidden\" id=\"song_section\" value=\"$song_section\">";

print $output; 

#######################################################################
### Functions

function print_cell_selectors( $ike ) {

  $new_output = "<div id=\"key_value_$ike\">
<select id=\"Music_Key_$ike\" onchange=\"load_chordtypes( $ike )\">
  <option value=\"_\" selected>_</option>
  <option value=\"A\">A</option>
  <option value=\"H\">Bb</option>
  <option value=\"B\">B</option>
  <option value=\"C\">C</option>
  <option value=\"I\">C#</option>
  <option value=\"D\">D</option>
  <option value=\"J\">Eb</option>
  <option value=\"E\">E</option>
  <option value=\"F\">F</option>
  <option value=\"K\">F#</option>
  <option value=\"G\">G</option>
  <option value=\"L\">Ab</option>
</select>
</div>
<div id=\"secret_$ike\"><input type=\"hidden\" id=\"chord_chosen_$ike\" value=\"0\"></div>
<br>
<div id=\"type_value_$ike\">";

$new_output .= "<select id=\"Chord_Type_$ike\">
  <option value=\"\">_</option>
</select>";

  $new_output .= "</div>"; 

  return $new_output; 

}

function print_cell_selectors_2() {

  $new_output = "<select id=\"Music_Key\">
  <option value=\"_\" selected>blank</option>
  <option value=\"A\">A</option>
  <option value=\"H\">Bb</option>
  <option value=\"B\">B</option>
  <option value=\"C\">C</option>
  <option value=\"I\">C#</option>
  <option value=\"D\">D</option>
  <option value=\"J\">Eb</option>
  <option value=\"E\">E</option>
  <option value=\"F\">F</option>
  <option value=\"K\">F#</option>
  <option value=\"G\">G</option>
  <option value=\"L\">Ab</option>
</select>
<br>
<select id=\"Chord_Type\">
  <option value=\"Q\">Major</option>
  <option value=\"R\">Minor</option>
  <option value=\"S\">Maj7</option>
  <option value=\"T\">Min7</option>
  <option value=\"U\">Dom7</option>
  <option value=\"V\">Alt7</option>
  <option value=\"W\">Dim</option>
  <option value=\"X\">1/2Dim</option>
  <option value=\"Y\">Aug</option>
  <option value=\"Z\">Sus</option>
</select>";

  return $new_output;

}

function print_cell_selectors_sharps( $ike ) {

  $new_output = "<div id=\"key_value_$ike\">
<select id=\"Music_Key_$ike\" onchange=\"load_chordtypes( $ike )\">
  <option value=\"_\" selected>_</option>
  <option value=\"A\">A</option>
  <option value=\"H\">A#</option>
  <option value=\"B\">B</option>
  <option value=\"C\">C</option>
  <option value=\"I\">C#</option>
  <option value=\"D\">D</option>
  <option value=\"J\">D#</option>
  <option value=\"E\">E</option>
  <option value=\"F\">F</option>
  <option value=\"K\">F#</option>
  <option value=\"G\">G</option>
  <option value=\"L\">G#</option>
</select>
</div>
<div id=\"secret_$ike\"><input type=\"hidden\" id=\"chord_chosen_$ike\" value=\"0\"></div>
<br>
<div id=\"type_value_$ike\">";

  $new_output .= "<select id=\"Chord_Type_$ike\">
  <option value=\"\">_</option>
</select>";

  $new_output .= "</div>"; 

  return $new_output; 

}

function print_cell_selectors_flats( $ike ) {

  $new_output = "<div id=\"key_value_$ike\">
<select id=\"Music_Key_$ike\" onchange=\"load_chordtypes( $ike )\">
  <option value=\"_\" selected>_</option>
  <option value=\"A\">A</option>
  <option value=\"H\">Bb</option>
  <option value=\"B\">B</option>
  <option value=\"C\">C</option>
  <option value=\"I\">Db</option>
  <option value=\"D\">D</option>
  <option value=\"J\">Eb</option>
  <option value=\"E\">E</option>
  <option value=\"F\">F</option>
  <option value=\"K\">Gb</option>
  <option value=\"G\">G</option>
  <option value=\"L\">Ab</option>
</select>
</div>
<div id=\"secret_$ike\"><input type=\"hidden\" id=\"chord_chosen_$ike\" value=\"0\"></div>
<br>
<div id=\"type_value_$ike\">";

  $new_output .= "<select id=\"Chord_Type_$ike\">
  <option value=\"\">_</option>
</select>";

  $new_output .= "</div>"; 

  return $new_output; 

}

?>
