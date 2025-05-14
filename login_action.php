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

// Collect form data
$email = $_POST['email'];
$password = $_POST['password'];

// Prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];

        // Redirect based on role
        if ($row['role'] === 'manager') {
            header('Location: manager_dashboard.html');
        } elseif ($row['role'] === 'volunteer') {
            header('Location: volunteer_dashboard.html');
        } else {
            echo "<script>alert('Invalid role. Please contact admin.'); window.location.href='login.html';</script>";
        }
        exit();
    } else {
        echo "<script>alert('Invalid password!'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('User not found!'); window.location.href='login.html';</script>";
}

$stmt->close();
$conn->close();
?>
