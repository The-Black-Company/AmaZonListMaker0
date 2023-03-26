<?php
$servername = getenv("MYSQL_HOST") ?: "db";
$username = "root";
$password = "toto42";
$dbname = "amazonlistmaker";

// Debug: Check if the servername is set correctly
// echo "Servername: " . $servername . "<br>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
