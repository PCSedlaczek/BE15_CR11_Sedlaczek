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

// $_GET Filters set
if (
  isset($_GET["location"]) ||
  isset($_GET["species"]) ||
  isset($_GET["breed"]) ||
  isset($_GET["gender"]) ||
  isset($_GET["size"]) ||
  isset($_GET["age"]) ||
  isset($_GET["senior"]) ||
  isset($_GET["status"])
) {
  // Filter by location
  if (isset($_GET["location"])) {
    $location = $_GET["location"];
    $filter = "location = '$location'";
    $title = "location: $location";
  }
  // Filter by species
  elseif (isset($_GET["species"])) {
    $species = $_GET["species"];
    $filter = "species = '$species'";
    $title = "species: $species";
  }
  // Filter by breed
  elseif (isset($_GET["breed"])) {
    $breed = $_GET["breed"];
    $filter = "breed = '$breed'";
    $title = "breed: $breed";
  }
  // Filter by gender
  elseif (isset($_GET["gender"])) {
    $gender = $_GET["gender"];
    $filter = "gender = '$gender'";
    $title = "gender: $gender";
  }
  // Filter by size
  elseif (isset($_GET["size"])) {
    $size = $_GET["size"];
    $filter = "size = '$size'";
    $title = "size: $size";
  }
  // Filter by age
  elseif (isset($_GET["age"])) {
    $age = $_GET["age"];
    $filter = "age = '$age'";
    $title = "age: $age";
  }
  // Fetch senior animals
  if (isset($_GET["senior"])) {
    $filter = "age > 8";
    $title = "Senior animals (older than 8 years)";
  }
  // Filter by status
  elseif (isset($_GET["status"])) {
    $status = $_GET["status"];
    $filter = "status = '$status'";
    $title = "Status: $status";
  }
  $query = "SELECT * FROM animals WHERE $filter";
}
// Fetch all animals
else {
  $query = "SELECT * FROM animals";
}

$animals = mysqli_query($connect, $query);

$tbody = "";

if (mysqli_num_rows($animals) > 0) {
  while($animal = mysqli_fetch_assoc($animals)) {
    $registered = date_create($animal["registered"]);
    $registered = date_format($registered, "j F Y");
    if($animal['status'] == "Available") {
      $color = "btn-outline-success";
    }

    $tbody .= "
      <tr>
        <td>
          <a class='btn badge btn-light text-dark' href='home.php?species=$animal[species]'>
            $animal[species]
          </a><br>
          <a href='../img/animals/$animal[img]'>
            <img class='img-thumbnail my-1' src='../img/animals/$animal[img]'>
            </a>
        </td>
        <td>
          <a href='../animals/view.php?id=$animal[id]' class='link-dark'>
            <h6 class='my-2'>$animal[name]</h6>
          </a>
          <a href='home.php?breed=$animal[breed]' class='link-dark'>
            $animal[breed]
          </a>
        </p>
        <p>
          <i class='bi bi-house'></i>
          <a href='home.php?location=$animal[location]' class='link-dark'>
            $animal[location]
          </a>
        </p>
        <p class='small text-muted'> 
          $registered
      </a>
        </p>
          <a href='home.php?status=$animal[status]' class='link-dark'>
            <button class='btn btn-sm $color'>
            $animal[status]</button>
          </a>
        </td>
        <td>
          <a class='btn btn-success btn-sm' href='view.php?id=$animal[id]'>View</a>
          <a class='btn btn-primary btn-sm' href='edit.php?id=$animal[id]'>Edit</a>
          <a class='btn btn-danger btn-sm' href='delete.php?id=$animal[id]'>Delete</a>
        </td>
      </tr>";
  };
} 
else {
  $tbody = "
    <tr>
      <td colspan='5'>
        <center>No Data Available</center>
      </td>
    </tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage animals</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?>
</head>

<body>
  <div class="container max-w m-auto">
    <div class="my-3 text-end">
      <a class="btn btn-sm btn-primary" href="add.php">Add</a>
      <a class="btn btn-sm btn-info" href="../panel.php">Panel</a>
    </div>

    <p class="h2 my-4">Manage Animals</p>

    <table class="table shadow-lg">
      <tbody>
        <?=$tbody?>
      </tbody>
    </table>
  </div>

</body>

</html>