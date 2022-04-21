<?php
session_start();

if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../user/home.php");
  exit;
}

// User Back button link to Home
if (isset($_SESSION["user"])) {
  $link = "../user/home.php";
  $page = "Profile";
}
// Admin Back button link to Admin Panel
if (isset($_SESSION["admin"])) {
  $link = "../panel.php";
  $page = "Admin Panel";
}

require_once "../comp/connect.php";

if (isset($_GET["id"]) && !empty($_GET["id"])) {
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
    if (!$description) {
      $d_description = "d-none";
    }
    $species = $entry["species"];
    $size = $entry["size"];
    $age = $entry["age"];
    $gender = $entry["gender"];
    $hobbies = $entry["hobbies"];
    if (!$hobbies) {
      $d_hobbies = "d-none";
    }
    $breed = $entry["breed"];
    if (!$breed) {
      $d_breed = "d-none";
    }
    $registered = date_create($entry["registered"]);
    $registered = date_format($registered, "j F Y");
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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= "$name"?> Details</title>
  <link rel="stylesheet" href="../css/style.css">
  <?php require_once "../comp/bootstrap.php"?></head>

<body>

  <div class="container max-w">
    <div class="m-auto mt-3">

      <div class="text-end">
        <a class="btn btn-sm btn-info link-light" href="<?=$link?>">Back</a>
      </div>
      <h2 class="text-white mt-0 mb-4">Animal details</h2>

      <table class="table shadow-lg">
        <tbody>
          <tr>
            <td>
              <a href="../user/home.php?species=<?=$species?>">
                <span class="badge bg-light text-dark"><?=$species?></span>
              </a><br>
              <a href="../img/animals/<?=$img?>">
                <img class="img-thumbnail my-1" src="../img/animals/<?=$img?>">
              </a>
            </td>

            <td>
              <p>
                <b>Name:</b>
                <?=$name?>
              </p>
              <p>
                <b>Location:</b>
                <a class="link-dark" href="../user/home.php?location=<?=$location?>">
                  <?=$location?>
                </a>
              </p>
              <p class="<?=$d_description?>">
                <b>Description:</b>
                  <?=$description?>
              </p>
              <p>
                <b>Size:</b>
                <a class="link-dark" href="../user/home.php?size=<?=$size?>">
                  <?=$size?>
                </a>
              <p>
              <p>
                <b>Age:</b>
                <a class="link-dark" href="../user/home.php?age=<?=$age?>">
                  <?=$age?>
                </a>
              </p>
              <p>
                <b>Gender:</b>
                <a class="link-dark" href="../user/home.php?gender=<?=$gender?>">
                  <?=$gender?>
                </a>
              </p>
              <p class="<?=$d_hobbies?>">
                <b>Hobbies:</b>
                <a class="link-dark" href="../user/home.php?hobbies=<?=$hobbies?>">
                  <?=$hobbies?>
                </a>
              </p>
              <p class="<?=$d_breed?>">
                <b>Breed:</b>
                <a class="link-dark" href="../user/home.php?breed=<?=$breed?>">
                  <?=$breed?>
                </a>
              </p>
              <p>
                <b>Registered:</b>
                <?=$registered?>
              </p>

              <a class=" btn btn-sm btn-light link-dark my-2" href="../user/home.php?status=<?=$status?>">
                <?=$status?>
              </a>

            </td>

          </tr>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>