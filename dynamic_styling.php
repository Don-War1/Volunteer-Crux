<?php
// Dynamic Styling Handler
$page_styles = [
    'index.html' => 'theme-home',
    'about.html' => 'theme-about',
    'contact.html' => 'theme-contact',
    'events.html' => 'theme-events',
    'login.html' => 'theme-login',
    'signup.html' => 'theme-signup',
    'volunteer_dashboard.html' => 'theme-volunteer-dashboard',
    'event_registration.html' => 'theme-volunteer-dashboard',
    'completed_events.html' => 'theme-volunteer-dashboard',
    'certificates.html' => 'theme-volunteer-dashboard',
    'volunteer_profile.html' => 'theme-volunteer-dashboard',
    'manager_dashboard.html' => 'theme-manager-dashboard',
    'create_event.html' => 'theme-manager-dashboard',
    'manage_events.html' => 'theme-manager-dashboard',
    'generate_certificates.html' => 'theme-manager-dashboard',
    'manager_profile.html' => 'theme-manager-dashboard'
];

// Get current page
$current_page = basename($_SERVER['PHP_SELF']);

// Determine the theme class
$theme_class = $page_styles[$current_page] ?? 'default-theme';

// Check user session for role
session_start();
$user_role = $_SESSION['role'] ?? 'guest';
$nav_class = $user_role === 'guest' ? 'navbar-horizontal' : 'navbar-vertical';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Styling for <?php echo ucfirst(str_replace('.html', '', $current_page)); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo $theme_class; ?>">

<header>
    <nav class="<?php echo $nav_class; ?>">
        <ul>
            <?php if ($user_role === 'guest'): ?>
                <li><a href="index.html">Home</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="events.html">Explore Events</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
            <?php elseif ($user_role === 'volunteer'): ?>
                <li><a href="volunteer_dashboard.html">Dashboard</a></li>
                <li><a href="event_registration.html">Register for Events</a></li>
                <li><a href="completed_events.html">Completed Events</a></li>
                <li><a href="certificates.html">Certificates</a></li>
                <li><a href="volunteer_profile.html">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php elseif ($user_role === 'manager'): ?>
                <li><a href="manager_dashboard.html">Dashboard</a></li>
                <li><a href="create_event.html">Create Event</a></li>
                <li><a href="manage_events.html">Manage Events</a></li>
                <li><a href="generate_certificates.html">Generate Certificates</a></li>
                <li><a href="manager_profile.html">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main>
    <h1>Welcome to <?php echo ucfirst(str_replace('.html', '', $current_page)); ?></h1>
    <p>This page is styled with the <strong><?php echo $theme_class; ?></strong> theme.</p>
</main>

<footer>
    <p>&copy; 2025 Volunteer Crux. All Rights Reserved.</p>
</footer>

</body>
</html>
