<?php
function notifyVolunteer($email, $name) {
    $subject = "Welcome to Volunteer Crux, $name!";

    $message = "Hi $name,\n\n" .
               "Thank you for joining Volunteer Crux! We are excited to have you onboard as a volunteer. " .
               "You can now explore volunteering opportunities and contribute to impactful events.\n\n" .
               "Log in to your account here: http://localhost/login.html\n\n" .
               "Best regards,\n" .
               "The Volunteer Crux Team";

    $headers = "From: no-reply@volunteercrux.com\r\n";

    // Send email
    if (mail($email, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}

// Example usage
$email = "newvolunteer@example.com";
$name = "New Volunteer";
if (notifyVolunteer($email, $name)) {
    echo "Notification sent to $name ($email).";
} else {
    echo "Failed to send notification to $name ($email).";
}
?>
