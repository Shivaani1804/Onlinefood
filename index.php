<?php
// Database connection settings
$servername = "my-mysql";
$username = "root"; // replace with your DB username
$password = "root"; // replace with your DB password
$database = "ofd"; // replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to database '$database' on server '$servername'";
?>
