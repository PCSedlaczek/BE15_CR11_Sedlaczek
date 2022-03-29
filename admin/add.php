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

require_once "../components/connect.php";

$suppliers = "";
$result = mysqli_query($connect, "SELECT * FROM suppliers");

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
  $suppliers .=
      "<option value='$row[supplierId]'>$row[sup_name]</option>";
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Animal</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php" ?>
</head>

<body>
  <fieldset>
    <legend class="h2">Add Animal</legend>
    <form action="actions/create.php" method="post" enctype="multipart/form-data">
      <table class="table">
        <tr>
          <th>Name</th>
          <td><input class="form-control" type="text" name="name" placeholder="Product Name" /></td>
        </tr>
        <tr>
          <th>Price</th>
          <td><input class="form-control" type="number" name="price" placeholder="Price" step="any" /></td>
        </tr>
        <tr>
          <th>Image</th>
          <td><input class="form-control" type="file" name="image"/></td>
        </tr>
        <tr>
          <th>Supplier</th>
          <td>
            <select class="form-select" name="supplier" aria-label="Select Supplier">
              <option selected value="NULL">Undefined</option>
              <?= $suppliers ?>
            </select>
          </td>
        </tr>
        <tr>
          <td>
            <button class="btn btn-success" type="submit">Add</button>
          </td>
          <td>
            <a href="index.php"><button class="btn btn-warning" type="button">Home</button></a>
          </td>
        </tr>
      </table>
    </form>
  </fieldset>

</body>

</html>