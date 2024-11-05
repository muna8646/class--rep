<?php
session_start();
include 'db_connection.php';

$username = $_POST['username'];
$password = md5($_POST['password']); 

// Query to check if the user exists
$query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    // Display the error message if the query failed
    die("Database query failed: " . mysqli_error($conn));
}

// If query was successful, proceed with login validation
if (mysqli_num_rows($result) > 0) {
    $_SESSION['username'] = $username;
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
}
?>
