<?php
require_once "../comp/connect.php";
require_once "../comp/upload.php";

// Start new session or continue previous one
session_start();

// Redirect to Login if not logged in
if (!isset($_SESSION["admin"]) && !isset($_SESSION["user"])) {
  header("Location: ../index.php");
  exit;
}

// Initialize variables
$error = false;
$link = $page =
  $fname = $fnameError =
  $lname = $lnameError =
  $email = $emailError =
  $phone = $phoneError =
  $address = $addressError =
  $city = $cityError =
  $zip = $zipError =
  $img = $imgError = "";

// User Back button link to Home
if (isset($_SESSION["user"])) {
  $link = "home.php";
  $page = "Profile";
}
// Admin Back button link to Admin Panel
if (isset($_SESSION["admin"])) {
  $link = "../admin/panel.php";
  $page = "Admin Panel";
}

// Fetch and populate form
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $query = "SELECT * FROM users WHERE id = $id";
  $result = mysqli_query($connect, $query);

  if (mysqli_num_rows($result) == 1) {
    $data = mysqli_fetch_assoc($result);
    $fname = $data["fname"];
    $lname = $data["lname"];
    $email = $data["email"];
    $phone = $data["phone"];
    $address = $data["address"];
    $city = $data["city"];
    $zip = $data["zip"];
    $img = $data["img"];
  }
}

// Update form
$class = "d-none";

if (isset($_POST["btn-update"])) {
  $id = $_POST["id"];

  // Sanitise user input to prevent SQL injections
  $fname = trim($_POST["fname"]); // Strip surrounding whitespace
  $fname = strip_tags($fname); // Strip HTML & PHP tags
  $fname = htmlspecialchars($fname); // Convert to HTML entities

  $lname = trim($_POST["lname"]);
  $lname = strip_tags($lname);
  $lname = htmlspecialchars($lname);

  $email = trim($_POST["email"]);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $phone = trim($_POST["phone"]);
  $phone = strip_tags($phone);
  $phone = htmlspecialchars($phone);

  $address = trim($_POST["address"]);
  $address = strip_tags($address);
  $address = htmlspecialchars($address);

  $city = trim($_POST["city"]);
  $city = strip_tags($city);
  $city = htmlspecialchars($city);

  $zip = trim($_POST["zip"]);
  $zip = strip_tags($zip);
  $zip = htmlspecialchars($zip);

  // Basic name validation
  if (empty($fname) || empty($lname)) {
    $error = true;
    $fnameError = "Please enter your full name and surname";
  } else if (strlen($fname) < 2 || strlen($lname) < 2) {
    $error = true;
    $fnameError = "Name and surname must have at least 2 characters";
  } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
    $error = true;
    $fnameError = "Name and surname must contain only letters and no spaces";
  }

  // Basic email validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $emailError = "Please enter valid email address";
  }

  // Initialize variable for image upload errors
  $uploadError = "";
  $imgArr = upload($_FILES["img"]);
  $img = $imgArr->fileName;

  $values = "
    fname = '$fname', 
    lname = '$lname', 
    email = '$email',
    phone = '$phone',
    address= '$address',
    city = '$city',
    zip = '$zip'";

  // Continue to update if no error
  if (!$error) {

    // New image chosen
    if ($imgArr->error === 0) {
      // Remove old image or reset to default
      ($_POST["img"] == "../img/users/user.png") ?: unlink("../img/users/$_POST[img]");
      $query = "UPDATE users SET $values, img = '$img' WHERE id = $id";
    }
    // No new image chosen
    else {
      $query = "UPDATE users SET $values WHERE id = $id";
    }

    $result = mysqli_query($connect, $query);

    if (mysqli_query($connect, $query) === true) {
      $class = "alert alert-success";
      $message = "The record was successfully updated";
      $uploadError = ($imgArr->error != 0) ? $imgArr->ErrorMessage : "";
      header("refresh:3;url=update.php?id=$id");
    } else {
      $class = "alert alert-danger";
      $message = "Error while updating record : <br>".$connect->error;
      $uploadError = ($imgArr->error != 0) ? $imgArr->ErrorMessage : "";
      header("refresh:3;url=update.php?id=$id");
    }
  }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="../css/signin.css">
  <?php require_once "../comp/bootstrap.php" ?>
</head>

<body class="text-center">
  
  <main class="form-signin">
    
    <!-- Update alert -->
    <div class="<?= $class ?>" role="alert">
      <p><?= ($message) ?? "" ?></p>
      <p><?= ($uploadError) ?? "" ?></p>
    </div>
    
    <!-- Signup form -->
    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data">
      <h1 class="h3 mb-3 fw-normal">Update profile</h1>

      <?php
      if (isset($errMSG)) {
      ?>
        <div class="alert alert-<?= $errTyp ?>">
          <p><?= $errMSG ?></p>
          <p><?= $uploadError ?></p>
        </div>
      <?php
      }
      ?>

      <div class="d-flex gap-2">
        <!-- First name input -->
        <div class="form-floating w-50">
          <input type="text" id="floatFname" name="fname" class="form-control form-control is-<?= $valid ?>" placeholder="First name" maxlength="35" value="<?= $fname ?>">
          <label for="floatFname">First name</label>
          <span class="text-danger"><?= $fnameError ?></span>
        </div>

        <!-- Last name input -->
        <div class="form-floating w-50">
          <input type="text" id="floatLname" name="lname" class="form-control form-control is-<?= $valid ?>" placeholder="Last name" maxlength="35" value="<?= $lname ?>">
          <label for="floatLname">Last name</label>
          <span class="text-danger"><?= $lnameError ?></span>
        </div>
      </div>

      <!-- Email input -->
      <div class="form-floating">
        <input type="email" class="form-control form-control is-<?= $valid ?>" id="floatEmail" placeholder="name@example.com" name="email" value="<?= $email ?>" maxlength="255">
        <label for="floatEmail">Email address</label>
        <span class="text-danger"><?= $emailError ?></span>
      </div>

      <!-- Phone input -->
      <div class="form-floating">
        <input type="tel" class="form-control form-control is-<?= $valid ?>" id="floatPhone" placeholder="Phone number" name="phone" value="<?= $phone ?>" maxlength="26">
        <label for="floatPhone">Phone number</label>
        <span class="text-danger"><?= $phoneError ?></span>
      </div>

      <!-- Address input -->
      <div class="form-floating">
        <input type="text" class="form-control form-control is-<?= $valid ?>" id="floatAddress" placeholder="Address" name="address" value="<?= $address ?>" maxlength="95">
        <label for="floatAddress">Address</label>
        <span class="text-danger"><?= $addressError ?></span>
      </div>


      <div class="d-flex gap-2">
        <!-- City input -->
        <div class="form-floating">
          <input type="text" name="city" class="form-control" placeholder="City" value="<?= $city ?>" maxlength="45">
          <label for="floatCity">City</label>
          <span class="text-danger"><?= $cityError ?></span>
        </div>

        <!-- ZIP input -->
        <div class="form-floating">
          <input type="text" name="zip" class="form-control" placeholder="ZIP Code" value="<?= $zip ?>" maxlength="10">
          <label for="floatZIP">ZIP</label>
          <span class="text-danger"><?= $zipError ?></span>
        </div>
      </div>

      <!-- Image upload -->
      <input class="form-control" type="file" name="img" value="<?= $img ?>">
      <span class="text-danger"><?= $imgError ?></span>
      
      <!-- Hidden input img -->
      <input type="hidden" name="img" value="<?= $img ?>">
      
      <!-- Hidden input ID -->
      <input type="hidden" name="id" value="<?= $data["id"] ?>">
      
      <!-- Update button -->
      <button type="submit" class="w-100 btn btn-block btn-lg btn-primary" name="btn-update">Save changes</button>

      <!-- Back Link -->
      <a class="nav-link" href="<?= $link ?>">Back to <?= $page ?></a>
    </form>
  </main>

</body>

</html>