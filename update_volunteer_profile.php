<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "if0_38171036_volunteer_crux";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current user ID
$user_id = $_SESSION['user_id'];
if (!$user_id) {
    die("Unauthorized access.");
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate current password
$sql_check = "SELECT password FROM users WHERE id = ? AND role = 'volunteer'";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("i", $user_id);
$stmt_check->execute();
$result = $stmt_check->get_result();
$user = $result->fetch_assoc();

if (!password_verify($current_password, $user['password'])) {
    die("Current password is incorrect.");
}

// Update name and email
$sql_update = "UPDATE users SET name = ?, email = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("ssi", $name, $email, $user_id);
$stmt_update->execute();

// Update password if provided
if (!empty($new_password) && $new_password === $confirm_password) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $sql_password = "UPDATE users SET password = ? WHERE id = ?";
    $stmt_password = $conn->prepare($sql_password);
    $stmt_password->bind_param("si", $hashed_password, $user_id);
    $stmt_password->execute();
}

// Success message
header("Location: volunteer_profile.html?status=success");
exit();

$conn->close();
?>
