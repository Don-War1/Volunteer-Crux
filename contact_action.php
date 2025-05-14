<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Admin email to receive messages
    $admin_email = "kvsaibhargav77@gmail.com";
    $subject = "New Contact Us Message from $name";

    // Email body
    $email_body = "You have received a new message from the Contact Us form:\n\n" .
                  "Name: $name\n" .
                  "Email: $email\n" .
                  "Message:\n$message\n";

    $headers = "From: $email\r\n";

    // Attempt to send the email
    if (mail($admin_email, $subject, $email_body, $headers)) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Failed to send message. Please try again later.'); window.location.href='contact.html';</script>";
    }
} else {
    header("Location: contact.html");
    exit();
}
?>
