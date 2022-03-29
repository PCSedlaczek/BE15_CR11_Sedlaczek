<?php
function upload($img, $path = "users")
{
  // Create object for file upload status
  $result = new stdClass(); 
  $result->fileName = "user.png";
  if (isset($_SESSION["admin"])) {
    $result->fileName = "animal.png";
  }  
  $result->error = true;

  // Collect data from object $img
  $fileName = $img["name"];
  $fileType = $img["type"];
  $fileTmpName = $img["tmp_name"];
  $fileError = $img["error"];
  $fileSize = $img["size"];

  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $filesAllowed = ["png", "jpg", "jpeg"];
  
  // No file uploaded
  if ($fileError == 4) {
    $result->ErrorMessage = "No image was chosen<br>It can always be updated later";
    return $result;
  } 
  else {
    // File extension valid
    if (in_array($fileExtension, $filesAllowed)) {
      // No file error
      if ($fileError === 0) {
        // File size smaller than 500KB (in bytes)
        if ($fileSize < 500000) {
          $fileNewName = uniqid("").".".$fileExtension;
          // Animal image path
          if ($path == "animals") {
            $src = "../img/animals/$fileNewName";
          }
          // User image path
          elseif ($path == "users") {
            $src = "../img/users/$fileNewName";
          }

          // File upload successful
          if (move_uploaded_file($fileTmpName, $src)) {
            $result->error = false;
            $result->fileName = $fileNewName;
            return $result;
          }
          // File upload failed
          else {
            $result->ErrorMessage = "There was an error uploading this file.";
            return $result;
          }
        }
        // File size bigger than 500KB
        else {
          $result->ErrorMessage = "This image is bigger than the permitted 500Kb<br> Please choose a smaller one and update your profile";
          return $result;
        }
      } 
      // Other upload error
      else {
        $result->ErrorMessage = "There was an error uploading this file<br>Error code: $fileError<br>Please check the PHP documentation for details";
        return $result;
      }
    }
    // File extension invalid
    else {
      $result->ErrorMessage = "This file type cannot be uploaded<br>Supported file types are JPG, JPEG and PNG";
      return $result;
    }
  }
}
