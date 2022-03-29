<?php
require_once "../comp/connect.php";

// Start new session or continue previous one
session_start();

// Redirect Admin to Admin Panel
if (isset($_SESSION["admin"])) {
  header("Location: ../admin/panel.php");
  exit;
}
// Redirect to Login if not logged in
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: index.php");
  exit;
}

// Fetch logged-in user's details
$user = $_SESSION["user"];
$query = "SELECT * FROM users WHERE id=$user";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$fname = $row["fname"];
$lname = $row["lname"];
$img = $row["img"];

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

// Run SQL query based on filter
$animals = mysqli_query($connect, $query);

// Create table body for query results
if (mysqli_num_rows($animals) > 0) {
  while($animal = mysqli_fetch_assoc($animals)) {
    $tbody = "
      <tr>
        <td>
          <a href='home.php?species=$animal[species]'>
            <button class='btn badge'>
              $animal[species]
            </button>
          </a><br>
        </td>
        <td>
          <a href='media/view.php?id=$animal[id]' class='link-light'>
            <h6 class='my-2'>$animal[name]</h6>
          </a>
          <a href='home.php?location=$animal[location]' class='link-light'>
            $animal[location]
          </a>
        </p>
        <p>
          <a href='home.php?registered=$animal[registered]' class='link-light'>
          $animal[registered]
      </a>
        </p>
          <a href='home.php?status=$animal[status]' class='link-light'>
            <button class='btn btn-sm'>
            $animal[status]</button>
          </a>
        </td>
        <td class='text-center'>
          <a href='view.php?id=$animal[id]'>
            <button class='btn btn-sm m-1' type='button'>Details</button>
          </a><br>
        </td>
      </tr>";
  }
}
// No query results
else {
  $tbody = "
    <tr>
      <td colspan='5'>
        <center>No Data Available</center>
      </td>
    </tr>";
}

// Close database connection
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?>
  <title>Browse our animals</title>
</head>

<body>
  <div class="hero p-3 mb-4 row align-items-center">
    <!-- User area -->
    <div class="col">
      <img class="userImage m-4 rounded-pill" src="../img/users/<?=$img?>" alt="<?=$fname?>">
    </div>
    <div class="col">
      <h2 class="text-white">Welcome <?=$fname?>!</h2>
    </div>
    <!-- Nav links -->
    <div class="col text-end">
      <div class="row">
        <a class="nav-link link-light" href="logout.php?logout">Log out</a>
        <a class="nav-link link-light" href="update.php?id=<?=$_SESSION["user"]?>">Update profile</a>
        <a class="nav-link link-light" href="adopt.php">Adoption history</a>
      </div>
    </div>
  </div>

  <div class="container-lg">
    <h2>Browse our animals</h2>
    <table class="table table-striped">
      <tbody>
        <?=$tbody?>
      </tbody>
    </table>
  </div>

</body>

</html>