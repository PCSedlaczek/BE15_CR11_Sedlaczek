<?php
require_once "comp/connect.php";

// Start new session or continue previous one
session_start();

// Redirect User to Home
if (isset($_SESSION["user"])) {
  header("Location: user/home.php");
  exit;
}
// Redirect Admin to Admin Panel
if (isset($_SESSION["admin"])) {
  header("Location: admin/panel.php");
}

// Initialize variables
$error = false;
$email = $emailError =
$pwd = $pwdError = "";

if (isset($_POST["btn-login"])) {

  // Sanitize user input to prevent SQL injections
  $email = trim($_POST["email"]); // Strip surrounding whitespace
  $email = strip_tags($email); // Strip HTML & PHP tags
  $email = htmlspecialchars($email); // Convert to HTML entities

  $pwd = trim($_POST["pwd"]);
  $pwd = strip_tags($pwd);
  $pwd = htmlspecialchars($pwd);

  // Validate email input
  if (empty($email)) {
    $error = true;
    $valid = "invalid";
    $emailError = "Please enter your email address";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $valid = "invalid";
    $emailError = "Please enter a valid email address";
  }

  // Validate password input
  if (empty($pwd)) {
    $error = true;
    $valid = "invalid";
    $pwdError = "Please enter your password";
  }

  // Continue to Login if no error
  if (!$error) {
    $valid = "valid";

    $pwd = hash("sha256", $pwd); // password hashing

    $sql = "SELECT id, fname, lname, pwd, status FROM users WHERE email = '$email'";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
    $count = mysqli_num_rows($result);

    // Valid login credentials
    if ($count == 1 && $row["pwd"] == $pwd) {
      if ($row["status"] == "admin") {
        $_SESSION["admin"] = $row["id"];
        header("Location: admin/panel.php");
      } else {
        $_SESSION["user"] = $row["id"];
        header("Location: user/home.php");
      }
    // Invalid login credentials
    } else {
      $errMSG = "Invalid credentials. Please try again.";
      $valid = "invalid";
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
  <title>User Login</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/signin.css">
  <?php require_once "comp/bootstrap.php"?>
</head>

<body class="text-center">

<!-- Login form -->
<main class="form-signin">
  <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>">
    <h1 class="h3 mb-3 fw-normal">User Login</h1>

    <?php
      if (isset($errMSG)) {
        echo $errMSG;
      }
     ?>
    
    <!-- E-Mail input -->
    <div class="form-floating">
      <input type="email" class="form-control form-control is-<?=$valid?>" id="floatEmail" placeholder="name@example.com" name="email" maxlength="255">
      <label for="floatEmail">Email address</label>
      <span class="text-danger"><?=$emailError?></span>
    </div>

    <!-- Password input -->
    <div class="form-floating">
      <input type="password" class="form-control form-control is-<?=$valid?>" id="floatPassword" placeholder="Password" name="pwd" maxlength="15">
      <label for="floatPassword">Password</label>
      <span class="text-danger"><?=$pwdError?></span>
    </div>

    <!-- Login button -->
    <button class="w-100 btn btn-block btn-lg btn-primary" name="btn-login" type="submit">Log in</button>
  </form>

  <!-- Signup link -->
  <a class="nav-link" href="user/register.php">Don't have an account?<br>Click here to register</a>
</main>

</body>
</html>