<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: login.php"); // Redirect to login page
  exit();
}

// Connect to database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "dbname";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$project_title = $_POST['project_title'];
$project_description = $_POST['project_description'];
$project_image = $_FILES['project_image']['name'];
$tmp_image = $_FILES['project_image']['tmp_name'];

// Upload image
$upload_dir = "uploads/";
$target_image = $upload_dir . basename($project_image);
move_uploaded_file($tmp_image, $target_image);

// Insert project data into database
$sql = "INSERT INTO projects (title, description, image) VALUES ('$project_title', '$project_description', '$project_image')";

if ($conn->query($sql) === TRUE) {
  echo "New project added successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
