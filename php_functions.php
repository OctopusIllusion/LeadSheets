<?php

###############################################3
### Functions

function chord_to_id( $chord ) {

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


function id_to_chord( $id ) {

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

function resolve_flats($raw_chord) {
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

function desolve_flats($smooth_chord) {
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

function simple_sql($sql_query) {
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

  $result = $conn->query($sql_query);

  return $result; 

}

function insert_to_db($sql_query) {

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

  $result = $conn->query($sql_query);

//  print var_dump($result); 
/*
  if($result == true) 
    print "Success\n";
  else
    print "Failure\n"; 
*/
  return $result; 

}

function query_database($sql_query) {

  // this function takes a sql query, creates connection with phpmyadmin database, runs the query, gets results, hands back the array with result inside

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

//  $state = "Connected successfully, made it this far\n";
//  return $state; 

  $result = $conn->query($sql_query);

  $resl = "";
  $big_arr = array();
  $inc = 1;

  if ($result->num_rows > 0) {
    $resl = 1;

    // output data of each row
    while($row = $result->fetch_assoc()) {
      //        echo "id: " . $row["id"]. " - name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
      //echo "name: " . $row["full_name"] . " - behavior: " . $row["behavior"] . "\n";

      //$small_arr = array();
      $small_arr = $row;
      //$small_arr[$inc] = $row["behavior"];
      $big_arr[$inc] = $small_arr;
      $inc++;
    }
  } else {
    //    echo "0 results";
    $resl = 0;
  }

  $conn->close();

  $output_str = "";
  $this_arr = $big_arr[1];

  if($resl == 0) 
    return "NADA"; 
//    return $resl;
  else
    return $this_arr;  

}

function big_query($sql_query) {

  // this function takes a sql query, creates connection with phpmyadmin database, runs the query, gets results, hands back the array with result inside

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

  $result = $conn->query($sql_query);

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
  //$this_arr = $big_arr[1];

  if($resl == 0) 
    return "NADA"; 
  else
    return $big_arr;  

}

function type_lookup( $type ) {
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


?>
