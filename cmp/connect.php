<?php

$host = "localhost";
$user = "root";
$pwd = "";
$db = "BE15_CR11_petadoption_Sedlaczek";

// Create connection
$connect = mysqli_connect($host, $user, $pwd, $db);

// Check connection
if (!$connect) {
  die("Connection failed: ".mysqli_connect_error());
}