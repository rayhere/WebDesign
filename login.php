<?php
session_start();

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
$username = $_POST['username'];
$password = $_POST['password'];

// Retrieve user from database
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // User found, verify password
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['password'])) {
    // Password is correct, set session variables
    $_SESSION['username'] = $username;
    $_SESSION['firstname'] = $row['firstname'];
    $_SESSION['lastname'] = $row['lastname'];
    header("Location: index.php"); // Redirect to main page
  } else {
    // Password is incorrect
    echo "Incorrect password";
  }
} else {
  // User not found
  echo "User not found";
}

$conn->close();
?>
