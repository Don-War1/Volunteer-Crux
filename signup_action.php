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

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$skills = $_POST['skills'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert volunteer into the database
$sql = "INSERT INTO users (name, email, password, role, skills) VALUES (?, ?, ?, 'volunteer', ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $name, $email, $hashed_password, $skills);

if ($stmt->execute()) {
    // Redirect to volunteer dashboard after successful registration
    $_SESSION['user_id'] = $conn->insert_id;
    $_SESSION['role'] = 'volunteer';
    header("Location: volunteer_dashboard.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
