<?php
require_once "../cmp/connect.php";
require_once "../cmp/upload.php";

// Start new session or continue previous one
session_start();

// Redirect if session started 
if (isset($_SESSION["user"])) {
  header("Location: home.php");
}
if (isset($_SESSION["admin"])) {
  header("Location: ../dashboard.php");
}

// Initialize variables
$error = false;
$fname = $fnameError =
$lname = $lnameError =
$email = $emailError =
$phone = $phoneError =
$address = $addressError =
$city = $cityError =
$zip = $zipError =
$img = $imgError =
$pwd = $pwdError = "";
$pwd2 = $pwd2Error = "";

if (isset($_POST["btn-signup"])) {

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

  $pwd = trim($_POST["pwd"]);
  $pwd = strip_tags($pwd);
  $pwd = htmlspecialchars($pwd);

  $pwd2 = trim($_POST["pwd2"]);
  $pwd2 = strip_tags($pwd2);
  $pwd2 = htmlspecialchars($pwd2);

  $uploadError = "";
  $img = upload($_FILES["img"]);

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
  // Check if email already exists in database
  else {
    $query = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($connect, $query);
    $count = mysqli_num_rows($result);
    if ($count != 0) {
      $error = true;
      $emailError = "The provided email address is already in use. Please use a different one.";
    }
  }
  // Password validation
  if (empty($pwd)) {
    $error = true;
    $pwdError = "Please enter password";
  } else if (strlen($pwd) < 6) {
    $error = true;
    $pwdError = "Password must have at least 6 characters";
  }

  if (empty($pwd2)) {
    $error = true;
    $pwd2Error = "Please enter password again";
  } else if ($pwd2 !== $pwd) {
    $error = true;
    $pwd2Error = "Passwords don't match";
  }

  // Password hashing for security
  $pwd = hash("sha256", $pwd);

  // Continue to signup if no error
  if (!$error) {

    $query = "INSERT INTO users(fname, lname, email, phone, address, city, zip, pwd, img)
    VALUES('$fname','$lname','$email','$phone','$address','$city','$zip','$pwd','$img->fileName')";
    $res = mysqli_query($connect, $query);

    if ($res) {
      $errTyp = "success";
      $errMSG = "Successfully registered, you can login now.";
      $uploadError = ($img->error != 0) ? $img->ErrorMessage : "";
    } else {
      $errTyp = "danger";
      $errMSG = "Something went wrong, try again later";
      $uploadError = ($img->error != 0) ? $img->ErrorMessage : "";
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
  <?php require_once "../cmp/bootstrap.php"?>
</head>

<body class="text-center">

  <!-- Signup form -->
  <main class="form-signin">
    <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" enctype="multipart/form-data">
    <h1 class="h3 mb-3 fw-normal">Sign Up</h1>

      <?php
      if (isset($errMSG)) {
     ?>
        <div class="alert alert-<?=$errTyp?>">
          <p><?=$errMSG?></p>
          <p><?=$uploadError?></p>
        </div>
      <?php
      }
     ?>

      <div class="d-flex gap-2">
        <!-- First name input -->
        <div class="form-floating w-50">
          <input type="text" id="floatFname" name="fname" class="form-control form-control is-<?=$valid?>" placeholder="First name" maxlength="35" value="<?=$fname?>">
          <label for="floatFname">First name</label>
          <span class="text-danger"><?=$fnameError?></span>
        </div>

        <!-- Last name input -->
        <div class="form-floating w-50">
          <input type="text" id="floatLname" name="lname" class="form-control form-control is-<?=$valid?>" placeholder="Last name" maxlength="35" value="<?=$lname?>">
          <label for="floatLname">Last name</label>
          <span class="text-danger"><?=$lnameError?></span>
        </div>
      </div>
      
      <!-- Email input -->
      <div class="form-floating">
        <input type="email" class="form-control form-control is-<?=$valid?>" id="floatEmail" placeholder="name@example.com" name="email" maxlength="255">
        <label for="floatEmail">Email address</label>
        <span class="text-danger"><?=$emailError?></span>
      </div>

      <!-- Phone input -->
      <div class="form-floating">
        <input type="tel" class="form-control form-control is-<?=$valid?>" id="floatPhone" placeholder="Phone number" name="phone" maxlength="26">
        <label for="floatPhone">Phone number</label>
        <span class="text-danger"><?=$phoneError?></span>
      </div>

      <!-- Address input -->
      <div class="form-floating">
        <input type="text" class="form-control form-control is-<?=$valid?>" id="floatAddress" placeholder="Address" name="address" maxlength="95">
        <label for="floatAddress">Address</label>
        <span class="text-danger"><?=$addressError?></span>
      </div>
      

      <div class="d-flex gap-2">
        <!-- City input -->
        <div class="form-floating">
        <input type="text" name="city" class="form-control" placeholder="City" maxlength="45" value="<?=$city?>">
        <label for="floatCity">City</label>
        <span class="text-danger"><?=$cityError?></span>
        </div>

        <!-- ZIP input -->
        <div class="form-floating">
        <input type="text" name="zip" class="form-control" placeholder="ZIP Code" maxlength="10" value="<?=$zip?>">
        <label for="floatZIP">ZIP</label>
        <span class="text-danger"><?=$zipError?></span>
        </div>
      </div>

      <!-- Image upload -->
      <input class="form-control" type="file" name="img">
      <span class="text-danger"><?=$imgError?></span>

      <!-- Password input -->
      <div class="form-floating">
      <input type="password" class="form-control form-control is-<?=$valid?>" id="floatPassword" placeholder="Enter Password" name="pwd" maxlength="15">
      <label for="floatPassword">Enter password</label>
      <span class="text-danger"><?=$pwdError?></span>
    </div>

    <div class="form-floating">
      <input type="password" class="form-control form-control is-<?=$valid?>" id="floatPassword2" placeholder="Password" name="pwd2" maxlength="15">
      <label for="floatPassword2">Enter password again</label>
      <span class="text-danger"><?=$pwd2Error?></span>
    </div>

      
      <!-- Submit button -->
      <button type="submit" class="w-100 btn btn-block btn-lg btn-primary" name="btn-signup">Sign Up</button>

      <!-- Login Link -->
      <a class="nav-link" href="../index.php">Log in here</a>
    </form>
  </main>

</body>

</html>