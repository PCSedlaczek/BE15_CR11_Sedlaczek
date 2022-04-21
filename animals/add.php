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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Animal</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?>
</head>

<body class="d-flex justify-content-center">
  <fieldset class="max-w shadow-lg p-4 m-5">
    <legend class="h2 my-3">Add animal</legend>
    
    <form action="actions/create.php" method="post" enctype="multipart/form-data">

      <table class="table">
        <tr>
          <th>Name</th>
          <td>
            <input class="form-control" type="text" name="name" placeholder="Animal name">
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
            <input class="form-control" type="text" name="location" placeholder="Location">
          </td>
        </tr>
        <tr>
          <th>Description</th>
          <td>
            <input class="form-control" type="text" name="description" placeholder="Description">
          </td>
        </tr>
        <tr>
          <th>Species</th>
          <td>
            <input class="form-control" type="text" name="species" placeholder="Species">
          </td>
        </tr>
        <tr>
          <th>Size</th>
          <td>
            <select class="form-select" name="size" aria-label="Select Size">
              <option selected>Size</option>
              <option value="tiny">Tiny</option>
              <option value="small">Small</option>
              <option value="medium">Medium</option>
              <option value="large">Large</option>
              <option value="xlarge">X-Large</option>
            </select>
        </tr>
        <tr>
          <th>Age</th>
          <td>
            <input class="form-control" type="number" name="age" placeholder="Age" step="any">
          </td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>
            <select class="form-select" name="gender" aria-label="Select Gender">
              <option selected>Gender</option>
              <option value="male">male</option>
              <option value="female">female</option>
            </select>
        </tr>
        <tr>
          <th>Hobbies</th>
          <td>
            <input class="form-control" type="text" name="hobbies" placeholder="Hobbies">
          </td>
        </tr>
        <tr>
          <th>Breed</th>
          <td>
            <input class="form-control" type="text" name="breed" placeholder="Breed">
          </td>
        </tr>
        <tr>
          <th>Registered</th>
          <td>
            <input class="form-control text-uppercase" type="date" name="registered">
          </td>
        </tr>
        <tr>
          <th>Status</th>
          <td>
            <select class="form-select" name="status" aria-label="Select Status">
              <option selected value="Available">Available</option>
              <option value="Adopted">Adopted</option>
              <option value="Reserved">Reserved</option>
              <option value="Weaning">Weaning</option>
              <option value="Recovering">Recovering</option>
              <option value="Withdrawn">Withdrawn</option>
              <option value="Deceased">Deceased</option>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <button class="btn btn-success" type="submit">Add</button>
          </td>
          <td>
            <a class="btn btn-warning" href="../index.php">Back</a>
          </td>
        </tr>
      </table>
    </form>
  </fieldset>

</body>

</html>