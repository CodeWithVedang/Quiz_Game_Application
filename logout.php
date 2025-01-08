<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_destroy();

// Return a JSON response indicating the user has been logged out
echo json_encode(['logged_out' => true]);
?>
