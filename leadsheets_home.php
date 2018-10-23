<?php

include("php_functions.php");

$output_str = 
"<!DOCTYPE html>

<html>
<head>
  <title>LeadSheets</title>
  <meta charset=\"utf-8\">
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js\"></script>
  <script src=\"leadsheets.js\"></script>
  <link rel=\"stylesheet\" type=\"text/css\" href=\"leadsheets.css\">
</head>
<body onload=\"load_basekey()\">
  <header>
  <div class=\"titleText\">LeadSheets</div>
  <br>
  <div class=\"localLinks\"><a href=\"leadsheets_home.php\">View Chords</a> &nbsp; &nbsp;
  <a href=\"leadsheets_create.html\">Create Song</a></div>
  </header>
  <br>
  <fieldset>
  <legend>Select a Song</legend>
  <p>Select a song to view the chords in your key of preference.</p>
 
  <ol>
    <li>Song<select id=\"Song_Title\" onchange=\"load_basekey()\">";


$query = "SELECT id, title, base_key FROM song_table";

$extras = big_query($query);

foreach($extras as $extry) {
  $new_str = "<option value=\"" . $extry["id"] . "\">" . $extry["title"] . "</option>\n";
  $output_str .= $new_str;
}


$output_str .="      </select>
    </li>
    <li><div id=\"choose_key\">Key<select id=\"Music_Key\">";

$letter_arr = array('A', 'H', 'B', 'C', 'I', 'D', 'J', 'E', 'F', 'K', 'G', 'L');

foreach($letter_arr as $arry) {
  $display_key = desolve_flats($arry);
  if($arry == $base_key) {
    $output_str .= "<option value=\"$arry\" selected>$display_key</option>";
  } else {
    $output_str .= "<option value=\"$arry\">$display_key</option>";
  }
}

$output_str .= "      </select></div>
    </li>
  </ol>

  <button onclick=\"return chordLookup( );\">Go!</button>
  </fieldset>
  <p><div id=\"ajax_output\"> </div> </p>
  
<div id=\"song_printout\"></div>

<script sync src=\"https://platform.twitter.com/widgets.js\"></script>

</body>
</html>";

print $output_str;

?>
