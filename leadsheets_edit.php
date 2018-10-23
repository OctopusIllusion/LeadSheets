<?php

include("php_functions.php");

$songid = $_GET["songid"];

$extra_quer = "SELECT id, title, base_key, is_major, sections, structure FROM song_table WHERE id = '$songid' ORDER BY id DESC limit 1";

$extras = query_database($extra_quer);
$new_id = $songid;
$songtitle = $extras["title"];
$songkey = $extras["base_key"];
if($extras["is_major"] == 1)
  $chordtype = 'Major';
else
  $chordtype = 'Minor';
$n_sections = $extras["sections"];
$the_structure = $extras["structure"];

$de_key = desolve_flats($songkey);


$html_out = "<html>
<head>
  <title>LeadSheets</title>
  <meta charset=\"utf-8\">
  <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js\"></script>
  <script src=\"leadsheets.js\"></script>
  <link rel=\"stylesheet\" type=\"text/css\" href=\"leadsheets.css\">
</head>
<body>
  <header>
  <div class=\"titleText\">LeadSheets</div>
  <br>
  <div class=\"localLinks\"><a href=\"leadsheets_home.php\">View Chords</a> &nbsp; &nbsp;
  <a href=\"leadsheets_create.html\">Create Song</a></div>
  </header>
  <br>
  <fieldset>
  <legend>Song Details</legend>
  <ol>
    <li>ID: $new_id </li>
    <li>Title: $songtitle </li>
    <li>Key: $de_key </li>
    <li>ChordType: $chordtype </li>
    <li> Number of Sections: $n_sections </li>
    <li> Song Structure: $the_structure </li>
  </ol>
  </fieldset>
  <input type=\"hidden\" id=\"final_id\" value=\"$new_id\">
  <input type=\"hidden\" id=\"final_key\" value=\"$songkey\">
  <input type=\"hidden\" id=\"final_chordtype\" value=\"$chordtype\">

  <br>
  <fieldset>
  <legend>Add Chords</legend>
  <p>Add a row of chords to the song. First choose Time Signature and Measures Per Line</p>

  <form>
  <ol> 
   <li>Beats Per Measure<select id=\"beats_per_measure\">
        <option value=\"2\">2</option>
        <option value=\"3\">3</option>
        <option value=\"4\" selected>4</option>
        <option value=\"5\">5</option>
        <option value=\"6\">6</option>
    </select></li> 
    <li>Measures Per Line<select id=\"measures_per_line\">
        <option value=\"2\">2</option>
        <option value=\"3\">3</option>
        <option value=\"4\" selected>4</option>
        <option value=\"5\">5</option>
        <option value=\"6\">6</option>
    </select></li>";

switch($n_sections) {
  case 1:
    $section_arr = array( 'A' ); 
    break;
  case 2:
    $section_arr = array( 'A', 'B');
    break;
  case 3:
    $section_arr = array( 'A', 'B', 'C'); 
    break; 
}

$html_out .= "<li>Section of Song:<select id=\"song_section\" onchange=\"toggle_song_section()\">";

foreach($section_arr as $arry) {
  $html_out .= "<option value=\"$arry\">$arry</option>\n";
}

$html_out .= "</select></li>";

$html_out .= "<li>Sharps<input type=\"radio\" name=\"keytype\" value=\"Sharps\">Flats<input type=\"radio\" name=\"keytype\" value=\"Flats\" checked></li>";

$html_out .= "</ol>
  </form>
  <button onclick=\"return deliverTemplate();\"><div class=\"butt_txt\">Load Template</div></button> 
  </fieldset> 

<div id=\"song_staging\"></div>

<br>
<fieldset>
<form>

View Song Section<select id=\"number_sections\">";

foreach($section_arr as $arry) {
  $html_out .= "<option value=\"$arry\">$arry</option>\n";
}

$html_out .= "</select>

</form>

<button onclick=\"return displaySection();\">View Chords</button>

</fieldset>

<div id=\"section_staging\"></div>

<br>
<fieldset>
<form>

Define Song Sections Pattern (use only 'A', 'B', 'C')
<br>
<input type=\"text\" id=\"song_sections\">

</form>
<button onclick=\"return commitSections();\">Save Structure</button>
</fieldset>

</body>
</html>";

print $html_out; 

##########################################3

?>
