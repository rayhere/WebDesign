<?php
session_start();
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['password']) &&
    !empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['username']) && !empty($_POST['password'])) {
      
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
      echo "Username already exists.";
    } else {
      $insert_query = "INSERT INTO users (firstname, lastname, username, password) VALUES ('$firstname', '$lastname', '$username', '$password')";
      if (mysqli_query($conn, $insert_query)) {
        $_SESSION['username'] = $username;
        header("Location: index.html");
        exit();
      } else {
        echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
      }
    }
  } else {
    echo "Please fill in all fields.";
  }
}
?>
