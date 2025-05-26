<?php
require_once __DIR__ . '/../includes/functions.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = trim($_POST['username'] ?? '');
    $displayName = trim($_POST['display_name'] ?? '');
    
    if (!empty($username) && !empty($displayName)) {
        if (addJudge($username, $displayName)) {
            header('Location: /admin?success=1');
            exit;
        } else {
            $error = "Failed to add judge. Username might already exist.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $displayName = trim($_POST['display_name'] ?? '');
    
    if (!empty($username) && !empty($displayName)) {
        if (addJudge($username, $displayName)) {
            header('Location: /judging-system/admin?success=1');
            
            exit;
        } else {
            $error = "Failed to add judge. Username might already exist.";
        }
    } else {
        $error = "Please fill all fields.";
    }
}

// If we get here, there was an error
header('Location: /judging-system/admin?error=' . urlencode($error ?? 'Unknown error'));
exit;
?>