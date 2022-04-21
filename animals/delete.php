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
  $entry = mysqli_fetch_assoc($result);

  if (mysqli_num_rows($result) == 1) {
    $id = $entry["id"];
    $name = $entry["name"];
    $img = $entry["img"];
    $location = $entry["location"];
    $description = $entry["description"];
    $species = $entry["species"];
    $size = $entry["size"];
    $age = $entry["age"];
    $gender = $entry["gender"];
    $hobbies = $entry["hobbies"];
    $breed = $entry["breed"];
    $registered = $entry["registered"];
    $status = $entry["status"];
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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Animal</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?>
</head>

<body class="d-flex justify-content-center">
  <fieldset class="max-w shadow-lg p-4 m-5">
    <legend class="h2 my-3">Delete animal</legend>
      <img class="img-thumbnail rounded" src="../img/animals/<?=$img?>" alt="<?=$name?>">
    </legend>
    <h5>You have selected the entry below:</h5>
    <table class="table w-75 mt-3">
      <tr>
        <td><?=$name?></td>
      </tr>
    </table>

    <h3 class="mb-4">Do you really want to delete this animal?</h3>
    <p>This action cannot be undone!</p>
    <form action="actions/delete.php" method="post">
      <input type="hidden" name="id" value="<?=$id?>">
      <input type="hidden" name="img" value="<?=$img?>">
      <button class="btn btn-danger" type="submit">Delete</button>
      <a class="btn btn-warning" href="amimals.php">Cancel</a>
    </form>
  </fieldset>
</body>

</html>