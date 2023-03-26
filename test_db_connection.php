<?php
$servername = "db";
$username = "root";
$password = "toto42";
$dbname = "amazonlistmaker";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}
?>
