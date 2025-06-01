<?php
// filepath: /opt/lampp/htdocs/quranic/api/user_profile.php

// Include config and token validation
require_once 'config.php';
require_once 'validate_token.php';

// Only handle GET requests for user profile
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    response('error', 'Only GET method is allowed');
}

// Validate token and get user ID
$userData = validateToken();
$userId = $userData['user_id'];
$userType = $userData['user_type'];

// Connect to database
$conn = getDBConnection();

// Prepare SQL statement to get user information
$stmt = $conn->prepare("SELECT id, email, first_name, last_name, gender, phone, date_of_birth, place_of_birth, address, academic_level, user_type FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 0) {
    response('error', 'User not found');
}

// Get user data
$user = $result->fetch_assoc();

// Get additional user information based on user_type
$additionalInfo = [];
switch ($user['user_type']) {
    case 'student':
        $stmt = $conn->prepare("
            SELECT s.id, s.student_code, s.parent_name, s.enrollment_date, 
                   GROUP_CONCAT(DISTINCT g.group_name) as groups
            FROM students s
            LEFT JOIN student_groups sg ON s.id = sg.student_id
            LEFT JOIN groups g ON sg.group_id = g.id
            WHERE s.user_id = ?
            GROUP BY s.id
        ");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $additionalInfo = $stmt->get_result()->fetch_assoc();
        break;
    
    case 'teacher':
        $stmt = $conn->prepare("
            SELECT t.id, t.specialization, t.qualification, t.employment_date,
                   GROUP_CONCAT(DISTINCT g.group_name) as groups
            FROM teachers t
            LEFT JOIN groups g ON t.id = g.teacher_id
            WHERE t.user_id = ?
            GROUP BY t.id
        ");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $additionalInfo = $stmt->get_result()->fetch_assoc();
        break;
    
    case 'admin':
        $stmt = $conn->prepare("
            SELECT id, department, position, responsibilities
            FROM supervisors
            WHERE user_id = ?
        ");
        $stmt->bind_param("i", $user['id']);
        $stmt->execute();
        $additionalInfo = $stmt->get_result()->fetch_assoc();
        break;
}

// Merge user data with additional info
$userData = array_merge($user, $additionalInfo ?? []);

// Return success response with user data
response('success', 'User profile retrieved successfully', $userData);
