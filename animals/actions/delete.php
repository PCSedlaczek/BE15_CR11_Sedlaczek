<?php
session_start();

if (isset($_SESSION["user"])) {
  header("Location: ../../home.php");
  exit;
}

if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../../index.php");
  exit;
}

require_once "../../comp/connect.php";

if ($_POST) {
  $id = $_POST["id"];
  $img = $_POST["img"];
  ($img == "animal.png") ?: unlink("../../img/animals/$img");

  $query = "DELETE FROM animals WHERE id = $id";
  if (mysqli_query($connect, $query)) {
    $class = "success";
    $message = "Successfully Deleted!";
    header("refresh:3;url=../animals.php?id=$id");
  } 
  else {
    $class = "danger";
    $message = "The entry was not deleted due to:<br>".$connect->error;
    header("refresh:3;url=../animals.php?id=$id");
  }
  mysqli_close($connect);
} 
else {
  header("location: ../../error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Delete Animal</title>
  <link rel="stylesheet" href="../../css/style.css">
  <?php require_once "../../comp/bootstrap.php"?>
</head>

<body>
  <div class="container max-w">
    <div class="mt-3 mb-3">
      <h1>Delete animal</h1>
    </div>
    
    <div class="alert alert-<?=$class?>" role="alert">
      <p><?=$message?></p>
    </div>
  </div>
</body>

</html>