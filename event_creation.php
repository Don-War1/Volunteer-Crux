<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "if0_38171036_volunteer_crux";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in and is a manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.html");
    exit();
}

// Handle Event Creation
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date_time = mysqli_real_escape_string($conn, $_POST['date_time']);
    $slots = intval($_POST['slots']);
    $required_skills = mysqli_real_escape_string($conn, $_POST['required_skills']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $created_by = $_SESSION['user_id'];

    $insert_event = "INSERT INTO events (title, location, date_time, slots, required_skills, description, created_by) 
                     VALUES ('$title', '$location', '$date_time', $slots, '$required_skills', '$description', $created_by)";

    if ($conn->query($insert_event) === TRUE) {
        echo "Event created successfully!";
        header("Location: manager_dashboard.html");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
