<?php
// filepath: /opt/lampp/htdocs/quranic/api/login.php

// Include config file
require_once 'config.php';

// Only handle POST requests for login
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    response('error', 'Only POST method is allowed');
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is valid
if (!isset($data['email']) || !isset($data['password'])) {
    response('error', 'Email and password are required');
}

// Sanitize input
$email = sanitizeInput($data['email']);
$password = $data['password']; // Don't sanitize password before verification

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response('error', 'Invalid email format');
}

// Connect to database
$conn = getDBConnection();

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, email, first_name, last_name, password, user_type FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 0) {
    response('error', 'Invalid email or password');
}

// Get user data
$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password'])) {
    response('error', 'Invalid email or password');
}

// Password is correct, create user data array without password
unset($user['password']);

// Get additional user information based on user_type
$additionalInfo = [];
switch ($user['user_type']) {
    case 'student':
        $stmt = $conn->prepare("SELECT id, student_code, parent_name FROM students WHERE user_id = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $additionalInfo = $stmt->get_result()->fetch_assoc();
        break;
    case 'teacher':
        $stmt = $conn->prepare("SELECT id, specialization, qualification FROM teachers WHERE user_id = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $additionalInfo = $stmt->get_result()->fetch_assoc();
        break;
    case 'admin':
        $stmt = $conn->prepare("SELECT id, department, position FROM supervisors WHERE user_id = ?");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $additionalInfo = $stmt->get_result()->fetch_assoc();
        break;
    // Add more cases if needed
}

// Merge user data with additional info
$userData = array_merge($user, $additionalInfo ?? []);

// Generate a simple token that includes the user ID for easier validation
// Format: "{user_id}:{timestamp}:{random_string}"
$timestamp = time();
$randomString = bin2hex(random_bytes(16));
$token = $user['id'] . ':' . $timestamp . ':' . $randomString;

// In a real application, you would store this token in a database
// For testing purposes, we'll just return it

// Return success response with user data and token
response('success', 'Login successful', [
    'user' => $userData,
    'token' => $token
]);
