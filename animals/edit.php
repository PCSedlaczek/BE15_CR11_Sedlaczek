<?php
session_start();

if (isset($_SESSION["user"])) {
  header("Location: ../home.php");
  exit;
}

if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../index.php");
  exit;
}

require_once "../comp/connect.php";

if ($_GET["id"]) {
  $id = $_GET["id"];
  $query = "SELECT * FROM animals WHERE id = $id";
  $result = mysqli_query($connect, $query);

  if (mysqli_num_rows($result) == 1) {
    $entry = mysqli_fetch_assoc($result);
    $id = $entry["id"];
    $name = $entry["name"];
    $img = $entry["img"];
    $location = $entry["location"];
    $description = $entry["description"];
    $species = $entry["species"];
    $age = $entry["age"];

    $size = $entry["size"];
    $sizeList = ["tiny","small","medium","large","x-large"];
    $sizes = "";
    foreach ($sizeList as $option) {
      if ($option == $size) {
        $sizes .= "<option value='$option' selected>$option</option>";
      }
      else {
        $sizes .= "<option value='$option'>$option</option>";
      }
    }

    $gender = $entry["gender"];
    $genderList = ["male","female"];
    $genders = "";
    foreach ($genderList as $option) {
      if ($option == $gender) {
        $genders .= "<option value='$option' selected>$option</option>";
      }
      else {
        $genders .= "<option value='$option'>$option</option>";
      }
    }

    $hobbies = $entry["hobbies"];
    $breed = $entry["breed"];
    $registered = $entry["registered"];

    $status = $entry["status"];
    $statusList = ["male","female"];
    $statuses = "";
    foreach ($statusList as $option) {
      if ($option == $status) {
        $statuses .= "<option value='$option' selected>$option</option>";
      }
      else {
        $statuses .= "<option value='$option'>$option</option>";
      }
    }
  } 
  else {
    header("location: ../error.php");
  }
  mysqli_close($connect);
} 
else {
  header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Edit Animal</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?>
</head>

<body class="d-flex justify-content-center">
  <fieldset class="max-w shadow-lg p-4 m-5">
    <legend class="h2 my-3">Edit animal
      <img class="img-thumbnail rounded" src="../img/animals/<?=$img?>" alt="<?=$name?>">
    </legend>

    <form action="actions/update.php" method="post" enctype="multipart/form-data">

      <table class="table">
        <tr>
          <th>Name</th>
          <td>
            <input class="form-control" type="text" name="name" placeholder="Animal name" value="<?=$name?>">
          </td>
        </tr>
        <tr>
          <th>Image</th>
          <td>
            <input class="form-control" type="file" name="img">
          </td>
        </tr>
        <tr>
          <th>Location</th>
          <td>
            <input class="form-control" type="text" name="location" placeholder="Location" value="<?=$location?>">
          </td>
        </tr>
        <tr>
          <th>Description</th>
          <td>
            <input class="form-control" type="text" name="description" placeholder="Description" value="<?=$description?>">
          </td>
        </tr>
        <tr>
          <th>Species</th>
          <td>
            <input class="form-control" type="text" name="species" placeholder="Species" value="<?=$species?>">
          </td>
        </tr>
        <tr>
          <th>Size</th>
          <td>
            <select class="form-select" name="size" aria-label="Select Size">
              <?=$sizes?>
            </select>
        </tr>
        <tr>
          <th>Age</th>
          <td>
            <input class="form-control" type="number" name="age" placeholder="Age" step="any" value="<?=$age?>">
          </td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>
            <select class="form-select" name="gender" aria-label="Select gender">
              <?=$genders?>
            </select>
        </tr>
        <tr>
          <th>Hobbies</th>
          <td>
            <input class="form-control" type="text" name="hobbies" placeholder="Hobbies" value="<?=$hobbies?>">
          </td>
        </tr>
        <tr>
          <th>Breed</th>
          <td>
            <input class="form-control" type="text" name="breed" placeholder="Breed" value="<?=$breed?>">
          </td>
        </tr>
        <tr>
          <th>Registered</th>
          <td>
            <input class="form-control text-uppercase" type="date" name="registered" value="<?=$registered?>">
          </td>
        </tr>
        <tr>
          <th>Status</th>
          <td>
            <select class="form-select" name="status" aria-label="Select status">
              <?=$statuses?>
            </select>
        </tr>
        <tr>
          <input type="hidden" name="id" value="<?=$entry["id"]?>">

          <input type="hidden" name="img" value="<?=$entry["img"]?>">
          <td>
            <button class="btn btn-success" type="submit">Save</button>
          </td>
          <td>
            <a class="btn btn-warning" href="animals.php">Back</a>
          </td>
        </tr>
      </table>
    </form>
  </fieldset>
</body>

</html>