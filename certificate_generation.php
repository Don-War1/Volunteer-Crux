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

// Check if user is a manager
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header("Location: login.html");
    exit();
}

// Generate Certificates
function generateCertificates($event_id) {
    global $conn;

    // Fetch attendees
    $attendees_query = "SELECT v.id AS volunteer_id, u.name, u.email FROM volunteers v 
                        JOIN users u ON v.user_id = u.id 
                        WHERE v.event_id = $event_id AND v.attended = TRUE AND v.certificate_generated = FALSE";
    $attendees_result = $conn->query($attendees_query);

    while ($row = $attendees_result->fetch_assoc()) {
        $volunteer_id = $row['volunteer_id'];
        $name = $row['name'];
        $email = $row['email'];

        // Generate certificate URL (example placeholder URL)
        $certificate_url = "certificates/certificate_$volunteer_id.pdf";

        // Store certificate details
        $insert_certificate = "INSERT INTO certificates (user_id, event_id, certificate_url) 
                              VALUES ($volunteer_id, $event_id, '$certificate_url')";
        $conn->query($insert_certificate);

        // Update volunteer status
        $update_volunteer = "UPDATE volunteers SET certificate_generated = TRUE WHERE id = $volunteer_id";
        $conn->query($update_volunteer);
    }

    echo "Certificates generated successfully!";
}

// Generate certificates if event_id is passed
if (isset($_GET['event_id'])) {
    generateCertificates($_GET['event_id']);
}

$conn->close();
?>
