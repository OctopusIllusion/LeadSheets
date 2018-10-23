// Javascript Functions

function validateForm() {
  var the_title = document.forms["song_specs"]["songtitle"].value;
  var the_key = document.forms["song_specs"]["songkey"].value;
  var the_type = document.forms["song_specs"]["chordtype"].value;
  var numb_secs = document.forms["song_specs"]["songsections"].value; 

  // if any of the three required fields are blank
  if( (the_title == "") || (the_key == "") || (the_type == "") || (numb_secs == "") ) {
    alert("One or more required fields is blank! Cannot proceed"); 
    return false; 
  }
}

function validateFormSilent() {
  var the_title = document.forms["song_specs"]["songtitle"].value;
  var the_key = document.forms["song_specs"]["songkey"].value;
  var the_type = document.forms["song_specs"]["chordtype"].value;
  var numb_secs = document.forms["song_specs"]["songsections"].value; 

  // if any of the three required fields are blank
  if( (the_title == "") || (the_key == "") || (the_type == "") || (numb_secs == "") ) {
    return false; 
  } else 
    return true; 
}


function get_and_post() {

  var the_title = document.forms["song_specs"]["songtitle"].value;
  var the_key = document.forms["song_specs"]["songkey"].value;
  var the_type = document.forms["song_specs"]["chordtype"].value;
  var numb_secs = document.forms["song_specs"]["songsections"].value;

  var d = validateFormSilent();

  if(d) {

    $.ajax({
      type: "POST",
      url: 'leadsheets_submit.php',
      data: {songtitle: the_title, songkey: the_key, chordtype: the_type, songsections: numb_secs},
      success: function(data){
        var new_id = data;
        var newurl = "leadsheets_edit.php?songid=" + new_id;
        window.location = newurl;
      }
    });

  } else {
    alert("Form was not Validated"); 
  }
}

function displaySection() {

  var song_id = document.getElementById('final_id').value;
  var song_section = document.getElementById('number_sections').value;
  var song_key = document.getElementById('final_key').value;

  $.ajax({
    type: "GET",
    url: 'display_section.php',
    data: {song: song_id, section: song_section, key: song_key},
    success: function(data){

      var str = data;
      $("#section_staging").html(str);
    }
  });

}

function load_basekey() {
 
  var the_id = document.getElementById('Song_Title').value;

  $.ajax({
    type: "GET",
    url: 'lookup_key.php',
    data: {id: the_id},
    success: function(data){
      var selec = document.getElementById('Music_Key');
      selec.selectedIndex = data; 
    }
  });
 
}

function load_chordtypes( beat_id ) {

  var the_secret = "chord_chosen_" + beat_id; 
  var secret_one = document.getElementById(the_secret).value; 

  if(secret_one == 1) {
  } else {

    var chosen_one = "chord_chosen_" + beat_id; 
    var chord_chosen = document.getElementById(chosen_one).value;
    var strang = "<input type=\"hidden\" id=\"" + chosen_one + "\" value=\"1\">";
    var secret_id = "#secret_" + beat_id;
    $(secret_id).html(strang);

    var type_select = "<select id=\"Chord_Type_" + beat_id + "\">  <option value=\"Q\">Major</option>  <option value=\"R\">Minor</option>  <option value=\"S\">Maj7</option>  <option value=\"T\">Min7</option>  <option value=\"U\">Dom7</option>  <option value=\"V\">Alt7</option>  <option value=\"W\">Dim</option>  <option value=\"X\">1/2Dim</option>  <option value=\"Y\">Aug</option>  <option value=\"Z\">Sus</option></select>";

    var type_id = "#type_value_" + beat_id;
    $(type_id).html(type_select); 
  }


}

function commitSections() {

  var the_sections = document.getElementById('song_sections').value;
  var song_id = document.getElementById('final_id').value;

  $.ajax({
    type: "GET",
    url: 'set_sections.php',
    data: {songid: song_id, structure: the_sections},
    success: function(data){
      alert("Song Section Defined");
    }
  });

}

function toggle_song_section() {
  var selected_section = document.getElementById('song_section').value; 
  var doxy = document.getElementById('number_sections');

  var the_int = letter_to_number(selected_section);
  doxy.selectedIndex = the_int; 
}

function letter_to_number( letty ) {
  var numb = "";
  switch(letty) {
    case 'A':
      numb = 0;
      break;
    case 'B':
      numb = 1;
      break;
    case 'C':
      numb = 2;
      break;
  }
  return numb; 
}

function cancelAdding() {
  var str = "";
  $("#song_staging").html(str);
}

function clearLine() {
  deliverTemplate();
}

function addChordLine() {

  var number_of_beats = document.getElementById('number_of_beats').value;
  var beats_pm = document.getElementById('beats_per_measure').value;

  var itt = 1; 
  var cnt = 1; 

  var new_chord_str = "";

  while(itt < number_of_beats) {

    var mk_tag = "Music_Key_" + itt; 
    var ct_tag = "Chord_Type_" + itt;

    var this_mk = document.getElementById( mk_tag ).value; 
    var this_ct = document.getElementById( ct_tag ).value;

    if( cnt == beats_pm) {
      var new_piece = this_mk + this_ct + ",";
      cnt = 1; 
    } else {
      var new_piece = this_mk + this_ct + ".";
      cnt++;
    }

    new_chord_str = new_chord_str + new_piece;

    itt++; 

  }

  var song_id = document.getElementById('final_id').value; 

  var song_section = document.getElementById('song_section').value;

  $.ajax({
    type: "GET",
    url: 'commit_chords.php',
    data: {song: song_id, chord_string: new_chord_str, section: song_section},
    success: function(data){

      displaySection();

    }
  });

}

// Testing function, not currently being used
function alertChords() {
  var beats = document.getElementById('beats_per_measure').value;
  var measures = document.getElementById('measures_per_line').value;
  var strang = "There are " + beats + " beats per measure and " + measures + " measures per line";
  alert(strang);
}

function editChords( song_id ) {
  var newurl = "leadsheets_edit.php?songid=" + song_id;
  window.location = newurl;
}

function deliverTemplate() {
  var beats = document.getElementById('beats_per_measure').value; 
  var measures = document.getElementById('measures_per_line').value; 
  var songsection = document.getElementById('song_section').value;
  var strang = "There are " + beats + " beats per measure and " + measures + " measures per line"; 
  var keyType = document.querySelector('input[name=keytype]:checked').value;

  $.ajax({
    type: "GET",
    url: 'chord_template.php',
    data: {beats_pm: beats, measures_pl: measures, section: songsection, keytype: keyType},
    success: function(data){
      var str = data;
      $("#song_staging").html(str);
    }
  });

}

// This function has been replaced, not currently being used
function retrieveChords() {

  var the_title = document.getElementById('Song_Title').value;
  var the_key = document.getElementById('Music_Key').value;

  // for now just run ajax call, get all entries in the songs table, and print it
  var test_phrase = "Hello"; 

  $.ajax({
    type: "GET",
    url: 'retrieve_song.php',
    data: {title: the_title, key: the_key},
    success: function(data){

      alert(data);
      var str = data; 
      $("#song_printout").html(str);
    }
  });

}

function chordLookup() {

  var the_title = document.getElementById('Song_Title').value;
  var the_key = document.getElementById('Music_Key').value;

  $.ajax({
    type: "GET",
    url: 'lookup_chords.php',
    data: {title: the_title, key: the_key},
    success: function(data){
      var str = data;
      $("#song_printout").html(str);
    }
  });


}


//////////////////////////////////////////
// Functions that aren't really being used

function helloWorld() {

  alert("Hello World"); 

}

function testFunction() {

  alert("Testing..."); 

}


function helloUser() {
	
  var the_user = document.getElementById('user').value;
  var hello = "Hello "; 
  var the_phrase = hello.concat(the_user); 
  alert(the_phrase);
	
}

