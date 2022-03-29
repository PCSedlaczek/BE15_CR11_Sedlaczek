<?php
require_once "../comp/connect.php";

// Start new session or continue previous one
session_start();

// Redirect to Login if not logged in
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../index.php");
  exit;
}
// Redirect User to Home
if (isset($_SESSION["user"])) {
  header("Location: home.php");
  exit;
}

$id = $_SESSION["admin"];
$query = "SELECT * FROM users WHERE status != 'admin'";
$result = mysqli_query($connect, $query);

// Create table body
$tbody = "";
if ($result->num_rows > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $tbody .= "<tr>
      <td>
        <img class='img-thumbnail rounded-circle' src='../img/users/$row[img]' alt='$row[fname]'></td>
      <td>
        $row[fname] $row[lname]<br>
        <a class='text-decoration-none' href='mailto:$row[email]'>$row[email]<br>
        <a class='text-decoration-none' href='mailto:$row[phone]'>$row[phone]<br>
      </td>
      <td>
        $row[address]<br>
        $row[zip] $row[city]<br>
        $row[country]<br>
      </td>
    </tr>";
  }
} else {
  $tbody = "<tr><td colspan='5'><center>No Data Available </center></td></tr>";
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?>
  <style type="text/css">
    .img-thumbnail {
      width: 100px !important;
    }
    td {
      text-align: left;
      vertical-align: middle;
    }
    tr {
      text-align: center;
    }
    .userImage {
      width: 100px;
      height: auto;
    }
  </style>
</head>

<body>
  <div class="hero p-3 mb-4 row align-items-center">
    <!-- User area -->
    <div class="col">
      <img class="userImage m-4 rounded-pill" src="../img/users/admin.jpg" alt="Admin Avatar">
    </div>
    <div class="col">
      <h2 class="text-white">Admin Panel</h2>
    </div>
    <!-- Nav links -->
    <div class="col text-end">
      <div class="row">
        <a class="nav-link link-light" href="../user/logout.php?logout">Log out</a>
        <a class="nav-link link-light" href="../user/update.php?id=<?=$_SESSION["admin"]?>">Update profile</a>
        <a class="nav-link link-light" href="animals.php">Manage animals</a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col mt-2">
        <p class="h2">Users</p>
        <table class="table table-striped">
          <thead class="table-info">
            <tr>
              <th>Photo</th>
              <th>Name & Contact</th>
              <th>Address</th>
            </tr>
          </thead>
          <tbody>
            <?= $tbody ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>