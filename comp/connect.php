<?php
// Create database connection
$connect = mysqli_connect(
  $host = "localhost",
  $user = "root",
  $pwd = "",
  $db = "BE15_CR11_petadoption_Sedlaczek"
);

// Check database connection
if (!$connect) {
  die("Database connection failed: ".mysqli_connect_error());
}