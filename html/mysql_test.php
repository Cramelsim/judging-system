<?php
header('Content-Type: text/plain');

// Connection parameters
$host = '127.0.0.1'; // Always use IP, not 'localhost'
$user = 'judging_user';
$pass = 'SecurePassword123!';
$db = 'judging_system';
$port = 3306;

// Test connection
echo "Testing MySQL connection...\n\n";

try {
    $conn = new mysqli($host, $user, $pass, $db, $port);
    
    if ($conn->connect_error) {
        throw new Exception("Connect failed: " . $conn->connect_error);
    }
    
    echo "SUCCESS! Connected to MySQL\n";
    echo "Server version: " . $conn->server_info . "\n";
    
    // Test query
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        echo "\nTables in database:\n";
        while ($row = $result->fetch_array()) {
            echo "- " . $row[0] . "\n";
        }
    } else {
        echo "\nNOTE: Database appears empty\n";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n\n";
    
    // Diagnostic info
    echo "PHP Version: " . phpversion() . "\n";
    echo "MySQLi available: " . (function_exists('mysqli_connect') ? 'Yes' : 'No') . "\n";
    
    // Network test
    echo "\nTesting network connectivity:\n";
    echo "Can connect to port 3306: ";
    $socket = @fsockopen($host, $port, $errno, $errstr, 2);
    echo $socket ? "Yes" : "No (Error $errno: $errstr)";
    
    // MySQL process check
    echo "\nMySQL running: ";
    echo trim(shell_exec("pgrep mysqld || echo 'No'"));
}
?>
