<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['project_title']) && isset($_POST['project_description']) && !empty($_POST['project_title']) && !empty($_POST['project_description'])) {

    // Get form data
    $project_title = $_POST['project_title'];
    $project_description = $_POST['project_description'];

    // Image upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["project_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["project_image"]["tmp_name"]);
      if($check !== false) {
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check file size
    if ($_FILES["project_image"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file)) {
        // Insert project data into database
        $insert_query = "INSERT INTO projects (title, description, image) VALUES ('$project_title', '$project_description', '$target_file')";
        if (mysqli_query($conn, $insert_query)) {
          echo "Project added successfully.";
          // Redirect to main page
          header("Location: index.html");
          exit();
        } else {
          echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  } else {
    echo "Please fill in all fields.";
  }
}
?>
