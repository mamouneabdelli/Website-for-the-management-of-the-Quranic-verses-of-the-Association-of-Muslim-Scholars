<?php
// filepath: /opt/lampp/htdocs/quranic/api/check_token.php

// Include config file
require_once 'config.php';

// Only handle GET requests for this endpoint
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    response('error', 'Only GET method is allowed');
}

// Get all headers
$headers = getallheaders();

// Check if Authorization header exists
if (!isset($headers['Authorization']) && !isset($headers['authorization'])) {
    response('error', 'Authorization header is required');
}

// Get the token from the Authorization header
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : $headers['authorization'];

// Authorization header should be in format: "Bearer {token}"
if (strpos($authHeader, 'Bearer ') !== 0) {
    response('error', 'Invalid Authorization header format');
}

$token = substr($authHeader, 7);

// Return success with token info
response('success', 'Token received', [
    'token' => $token,
    'token_parts' => explode(':', $token)
]);
?>
