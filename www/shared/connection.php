<?php
$servername = "localhost";
$username = "root";
$password = "password";
$db_name = "library_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>