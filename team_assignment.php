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

// Fetch event details
$event_id = $_POST['event_id'];
$sql_event = "SELECT * FROM events WHERE id = ?";
$stmt_event = $conn->prepare($sql_event);
$stmt_event->bind_param("i", $event_id);
$stmt_event->execute();
$event_result = $stmt_event->get_result();
$event = $event_result->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

// Fetch registered volunteers
$sql_volunteers = "SELECT users.id, users.name, users.skills FROM registrations
                   JOIN users ON registrations.user_id = users.id
                   WHERE registrations.event_id = ? AND registrations.status = 'registered'";
$stmt_volunteers = $conn->prepare($sql_volunteers);
$stmt_volunteers->bind_param("i", $event_id);
$stmt_volunteers->execute();
$volunteers_result = $stmt_volunteers->get_result();
$volunteers = [];

while ($row = $volunteers_result->fetch_assoc()) {
    $volunteers[] = $row;
}

// Assign teams based on complementary skills
$teams = [];
while (!empty($volunteers)) {
    $team = [];
    $skills_used = [];

    foreach ($volunteers as $key => $volunteer) {
        $volunteer_skills = explode(",", $volunteer['skills']);

        // Check for complementary skills
        $is_complementary = true;
        foreach ($volunteer_skills as $skill) {
            if (in_array(trim($skill), $skills_used)) {
                $is_complementary = false;
                break;
            }
        }

        if ($is_complementary) {
            $team[] = $volunteer;
            $skills_used = array_merge($skills_used, $volunteer_skills);
            unset($volunteers[$key]);
        }
    }

    $teams[] = $team;
}

// Display teams
foreach ($teams as $index => $team) {
    echo "<h3>Team " . ($index + 1) . "</h3>";
    echo "<ul>";
    foreach ($team as $member) {
        echo "<li>" . htmlspecialchars($member['name']) . " - Skills: " . htmlspecialchars($member['skills']) . "</li>";
    }
    echo "</ul>";
}

$conn->close();
?>

