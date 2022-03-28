<?php
// Start new session or continue previous one
session_start();

// Redirect if not logged in as admin or user
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../index.php");
  exit;
} else if (isset($_SESSION["user"])) {
  header("Location: home.php");
} else if (isset($_SESSION["admin"])) {
  header("Location: ../dashboard.php");
}

// End session and redirect to index
if (isset($_GET["logout"])) {
  unset($_SESSION["user"]);
  unset($_SESSION["admin"]);
  session_unset();
  session_destroy();
  header("Location: ../index.php");
  exit;
}
