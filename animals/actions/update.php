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
require_once "../../comp/upload.php";

if ($_POST) {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $location = $_POST["location"];
  $description = $_POST["description"];
  $species = $_POST["species"];
  $size = $_POST["size"];
  $age = $_POST["age"];
  $gender = $_POST["gender"];
  $hobbies = $_POST["hobbies"];
  $breed = $_POST["breed"];
  $registered = $_POST["registered"];
  $status = $_POST["status"];

  // variable for image upload errors
  $uploadError = "";

  $img = upload($_FILES["img"], "animal");

  $table = "";
  $default = "animal.png";
  $values = "
    name='$name', 
    description='$description', 
    species='$species', 
    size='$size', 
    age=$age, 
    gender='$gender', 
    hobbies='$hobbies', 
    breed='$breed', 
    registered='$registered', 
    status='$status'";

  if ($img->error === 0) {
    ($_POST["img"] == $default) ?: unlink("../../img/animals/$_POST[img]");
    $query = "UPDATE animals SET $values, img = '$img->fileName' WHERE id = $id";
  } else {
    $query = "UPDATE animals SET $values WHERE id = $id";
  }

  if (mysqli_query($connect, $query)) {
    $class = "success";
    $message = "The record was successfully updated";
    $uploadError = ($img->error != 0) ?
      $img->ErrorMessage : "";
    header("refresh:2;url=../edit.php?id=$id");
  } 
  else {
    $class = "danger";
    $message = "Error while updating record:<br>".mysqli_connect_error();
    $uploadError = ($img->error != 0) ?
      $img->ErrorMessage : "";
    header("refresh:2;url=../edit.php?id=$id");
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
  <title>Update Animal</title>
  <link rel="stylesheet" href="../../css/style.css">
  <?php require_once "../../comp/bootstrap.php"?>
</head>

<body>
  <div class="container max-w">
    <div class="mt-3 mb-3">
      <h1>Update animal</h1>
    </div>
    <div class="alert alert-<?=$class?>" role="alert">
      <p><?=($message) ?? ""?></p>
      <p><?=($uploadError) ?? ""?></p>
    </div>
  </div>
</body>

</html>