<?php
// Detailed connection test
header('Content-Type: text/plain');

try {
    $conn = new mysqli(
        '127.0.0.1',
        'judging_user',
        'SecurePassword123!',
        'judging_system',
        3306
    );
    
    echo "CONNECTION SUCCESS!\n";
    echo "MySQL Server: ".$conn->server_info."\n";
    echo "Protocol: ".$conn->protocol_version."\n";
    
    $conn->close();
} catch (Exception $e) {
    echo "CONNECTION FAILED:\n";
    echo "Error: ".$e->getMessage()."\n";
    echo "PHP Version: ".phpversion()."\n";
    
    // Network diagnostics
    echo "\nNETWORK CHECKS:\n";
    echo "Port 3306 open: ";
    echo (bool)@fsockopen('127.0.0.1', 3306, $errno, $errstr, 1) ? "Yes" : "No ($errstr)";
    
    echo "\nMySQL Process: ";
    echo trim(shell_exec("pgrep mysqld || echo 'Not running'"));
}
?>
