<?php
session_start(); // Start session
include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

    if (empty($email) || empty($password)) {
        die("<script>alert('All fields are required!'); window.location.href='login.php';</script>");
    }

    // Prepare statement to fetch user_id and password
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();
        
        if ($password === $stored_password) { // Note: Use password_hash() in production
            $_SESSION['user_id'] = $user_id; // Store user_id in session
            echo "<script>alert('Login successful!'); window.location.href='new.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>