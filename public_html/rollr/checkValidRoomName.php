<?php

function runFetchQuery($sqlCommand){
  $dbconfig = parse_ini_file("/var/sites/c/colinroitt.uk/dbConf.ini"); //get log in details from config ini file
  $servername = $dbconfig[rollr_servername];
  $username = $dbconfig[rollr_username];
  $password = $dbconfig[rollr_password];

  $conn = mysqli_connect($servername, $username, $password);    //connect

//check if connected
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error()); //die function exits current php script
  }

  //$sql = $sqlCommand;
  $sqlr = mysqli_query($conn, $sqlCommand);
  $r = mysqli_fetch_array($sqlr);
  mysqli_close($conn);

  return $r;
}

header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<response>';
  $roomName = $_GET['roomName'];
  $sqlGetRooms = "SELECT roomName FROM colinroi_rollr.rooms WHERE roomName = '$roomName'";
  $nameArray = runFetchQuery($sqlGetRooms);
  if($nameArray["roomName"] == $roomName){
    echo 'not valid' . $nameArray["roomName"] . ' - ' . $roomName;
  }else {
    echo '0';
  }

echo'</response>';



?>
