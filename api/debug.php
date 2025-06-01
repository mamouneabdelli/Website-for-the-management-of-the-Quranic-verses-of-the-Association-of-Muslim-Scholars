<?php
// filepath: /opt/lampp/htdocs/quranic/api/debug.php

// Include config file
require_once 'config.php';

// Set content type to JSON
header('Content-Type: application/json; charset=UTF-8');

// Get info about headers
$requestHeaders = [];
if (function_exists('getallheaders')) {
    $requestHeaders = getallheaders();
} else {
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $requestHeaders[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
}

// Check database connection
$dbStatus = 'Unknown';
$dbError = '';
try {
    $conn = getDBConnection();
    $dbStatus = 'Connected';
    
    // Count users
    $query = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($query);
    $userCount = $result->fetch_assoc()['count'];
} catch (Exception $e) {
    $dbStatus = 'Error';
    $dbError = $e->getMessage();
}

// Information to return
$debug = [
    'status' => 'success',
    'message' => 'Debug information',
    'data' => [
        'request' => [
            'method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown',
            'url' => $_SERVER['REQUEST_URI'] ?? 'Unknown',
            'headers' => $requestHeaders,
            'raw_post' => file_get_contents("php://input"),
            'post' => $_POST,
            'get' => $_GET
        ],
        'database' => [
            'status' => $dbStatus,
            'error' => $dbError,
            'user_count' => $userCount ?? 0
        ],
        'server' => [
            'php_version' => phpversion(),
            'date' => date('Y-m-d H:i:s'),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'
        ]
    ]
];

// Return JSON with debug info
echo json_encode($debug, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
