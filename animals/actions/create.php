<?php
session_start();

if (isset($_SESSION["user"])) {
  header("Location: ../../home.php");
  exit ;
}

if (!isset($_SESSION["admin"]) && !isset ($_SESSION["user"])) {
  header("Location: ../../index.php");
  exit ;
}

require_once "../../comp/connect.php";
require_once "../../comp/upload.php";

if ($_POST) {
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

  // Variable for image upload errors
  $uploadError = "";
  
  $img = upload($_FILES["img"], "animal");

  $query = "INSERT INTO animals (name, img, location, description, species, size, age, gender, hobbies, breed, registered, status) VALUES ('$name', '$img->fileName', '$location', '$description', '$species', '$size', $age, '$gender', '$hobbies', '$breed', '$registered', '$status')";

  if (mysqli_query($connect, $query)) {
    $class = "success";
    $message = "The entry below was successfully created:<br>
    <table>
      <tr>
        <td>Name:</td>
        <td>$name</td>
      </tr>
      <tr>
        <td>Location:</td>
        <td>$location</td>
      </tr>
      <tr>
        <td>Description:</td>
        <td>$description</td>
      </tr>
      <tr>
        <td>Species:</td>
        <td>$species</td>
      </tr>
      <tr>
        <td>Size:</td>
        <td>$size</td>
      </tr>
      <tr>
        <td>Age:</td>
        <td>$age</td>
      </tr>
      <tr>
        <td>Gender:</td>
        <td>$gender</td>
      </tr>
      <tr>
        <td>Hobbies:</td>
        <td>$hobbies</td>
      </tr>
      <tr>
        <td>Breed:</td>
        <td>$breed</td>
      </tr>
      <tr>
        <td>Registered:</td>
        <td>$registered</td>
      </tr>
      <tr>
        <td>Status:</td>
        <td>$status</td>
      </tr>
    </table>
    <hr>";
    
    $uploadError = ($img->error != 0) ?
      $img->ErrorMessage : "";
    header("refresh:2;url=../../animals/animals.php");
  } 
  else {
    $class = "danger";
    $message = "Error while creating record. Try again:<br>".$connect->error;
    $uploadError = ($img->error != 0) ?
      $img->ErrorMessage : "";
    header("refresh:2;url=../../animals/animals.php");
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
  <title>Create Animal</title>
  <link rel="stylesheet" href="../../css/style.css">
  <?php require_once "../../comp/bootstrap.php"?>
</head>

<body>
  <div class="container max-w">
    <div class="mt-3 mb-3">
      <h1>Create animal</h1>
    </div>
    <div class="alert alert-<?=$class?>" role="alert">
      <p><?=($message) ?? ""?></p>
      <p><?=($uploadError) ?? ""?></p>
    </div>
  </div>
</body>

</html>