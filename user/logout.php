<?php
// Start new session or continue previous one
session_start();

// Redirect to Login if not logged in
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../index.php");
  exit;
} 
// Redirect User to Home
else if (isset($_SESSION["user"])) {
  header("Location: home.php");
} 
// Redirect Admin to Admin Panel
else if (isset($_SESSION["admin"])) {
  header("Location: ../admin/panel.php");
}

// End session and redirect to Login
if (isset($_GET["logout"])) {
  unset($_SESSION["user"]);
  unset($_SESSION["admin"]);
  session_unset();
  session_destroy();
  header("Location: ../index.php");
  exit;
}
