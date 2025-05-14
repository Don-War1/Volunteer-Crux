<?php
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

// Fetch events from the database
$sql = "SELECT id, title, location, date, slots, description FROM events ORDER BY date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode([]);
}

$conn->close();
?>
