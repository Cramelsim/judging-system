<?php
$db_host = getenv('DB_HOST') ?: '127.0.0.1';
$conn = new mysqli(
    $db_host,
    getenv('DB_USER') ?: 'judging_user',
    getenv('DB_PASS') ?: 'SecurePassword123!',
    getenv('DB_NAME') ?: 'judging_system',
    getenv('DB_PORT') ?: 3306
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>