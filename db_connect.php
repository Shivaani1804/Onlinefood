<?php
$servername = "my-mysql"; 
$username = "root"; 
$password = "root"; 
$database = "ofd";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>  
