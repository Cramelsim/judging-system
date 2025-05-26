<?php
// Force TCP with native password auth
$conn = new mysqli();
$conn->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$conn->real_connect(
    '127.0.0.1',          // Must use IP
    'judging_user',
    'SecurePassword123!',
    'judging_system',
    3306,                 // Explicit port
    null,                 // No socket
    MYSQLI_CLIENT_COMPRESS
);

if ($conn->connect_error) {
    error_log("DB Connection Failed: ".$conn->connect_error);
    die("Database maintenance in progress. Please try again later.");
}

// Verify connection works
$conn->query("SET SESSION sql_mode='TRADITIONAL'");
?>