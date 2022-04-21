<?php
// Start new session or continue previous one
session_start();

// Redirect to Login if not logged in
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../index.php");
  exit;
}

require_once "../comp/connect.php";
require_once "../comp/upload.php";