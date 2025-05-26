<?php
header('Content-Type: text/plain');

// Connection parameters
$config = [
    'host' => '127.0.0.1', // Never use 'localhost'
    'user' => 'judging_user',
    'pass' => 'SecurePassword123!',
    'db'   => 'judging_system',
    'port' => 3306
];

echo "MySQL Connection Test\n";
echo "====================\n";

// Test 1: Basic connection
echo "\n[1] Testing basic connection...\n";
try {
    $conn = new mysqli($config['host'], $config['user'], $config['pass'], $config['db'], $config['port']);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    echo "✓ Connected successfully\n";
    
    // Test 2: Query execution
    echo "\n[2] Testing query execution...\n";
    if ($result = $conn->query("SHOW TABLES")) {
        echo "✓ Query succeeded. Found tables: " . $result->num_rows . "\n";
        while ($row = $result->fetch_array()) {
            echo "  - " . $row[0] . "\n";
        }
    } else {
        echo "✗ Query failed: " . $conn->error . "\n";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "✗ " . $e->getMessage() . "\n";
    
    // Advanced diagnostics
    echo "\nAdvanced Diagnostics:\n";
    echo "--------------------\n";
    echo "PHP Version: " . phpversion() . "\n";
    echo "MySQLi enabled: " . (extension_loaded('mysqli') ? 'Yes' : 'No') . "\n";
    
    // Network test
    echo "\nNetwork Test:\n";
    $socket = @fsockopen($config['host'], $config['port'], $errno, $errstr, 2);
    echo "Port {$config['port']} accessible: " . ($socket ? "Yes" : "No (Error $errno: $errstr)") . "\n";
    
    // Process check
    echo "\nProcess Check:\n";
    echo "MySQL running: " . (trim(shell_exec("pgrep mysqld || echo 'No'")) . "\n");
    
    // Configuration check
    echo "\nMySQL Config:\n";
    echo "bind-address: " . shell_exec("sudo grep -h bind-address /etc/mysql/*.cnf") . "\n";
}
?>