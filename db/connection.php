<?php

$host = "localhost";
$user = "root";
$pass = "";
$db_name = "ttc_db";

$connect = mysqli_connect($host, $user, $pass, $db_name);

if(!$connect){
    die("Connecion error");
}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>