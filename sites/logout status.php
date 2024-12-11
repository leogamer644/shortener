<?php
session_start();

if (isset($_SESSION['loggedinst'])) {
    // Unset admin-specific session data
    unset($_SESSION['loggedinst']);
    $message = "Sysadmin logged out successfully.";
} else {
    $message = "No active session to log out from.";
}

// Redirect or display a logout message
header("Location: ../index.html");
exit;

?>
