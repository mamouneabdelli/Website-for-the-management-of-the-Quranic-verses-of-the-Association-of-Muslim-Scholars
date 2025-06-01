<?php
// filepath: /opt/lampp/htdocs/quranic/api/groups.php

// Include config and token validation
require_once 'config.php';
require_once 'validate_token.php';

// Only handle GET requests for groups
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    response('error', 'Only GET method is allowed');
}

// Validate token and get user data
$userData = validateToken();
$userId = $userData['user_id'];
$userType = $userData['user_type'];

// Connect to database
$conn = getDBConnection();

// Get groups based on user type
$groups = [];

switch ($userType) {
    case 'student':
        // Get student ID
        $stmt = $conn->prepare("SELECT id FROM students WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            response('error', 'Student not found');
        }
        
        $student = $result->fetch_assoc();
        $studentId = $student['id'];
        
        // Get groups for the student
        $stmt = $conn->prepare("
            SELECT g.id, g.group_name, g.capacity, g.academic_year, g.start_date, g.end_date,
                   CONCAT(u.first_name, ' ', u.last_name) as teacher_name,
                   sg.enrollment_date, sg.status
            FROM student_groups sg
            JOIN groups g ON sg.group_id = g.id
            JOIN teachers t ON g.teacher_id = t.id
            JOIN users u ON t.user_id = u.id
            WHERE sg.student_id = ?
        ");
        $stmt->bind_param("i", $studentId);
        break;
        
    case 'teacher':
        // Get teacher ID
        $stmt = $conn->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            response('error', 'Teacher not found');
        }
        
        $teacher = $result->fetch_assoc();
        $teacherId = $teacher['id'];
        
        // Get groups for the teacher
        $stmt = $conn->prepare("
            SELECT g.id, g.group_name, g.capacity, g.academic_year, g.start_date, g.end_date,
                   g.description,
                   (SELECT COUNT(*) FROM student_groups WHERE group_id = g.id) as student_count
            FROM groups g
            WHERE g.teacher_id = ?
        ");
        $stmt->bind_param("i", $teacherId);
        break;
        
    case 'admin':
    case 'super_admin':
        // Get all groups for admin
        $stmt = $conn->prepare("
            SELECT g.id, g.group_name, g.capacity, g.academic_year, g.start_date, g.end_date,
                   g.description,
                   CONCAT(u.first_name, ' ', u.last_name) as teacher_name,
                   (SELECT COUNT(*) FROM student_groups WHERE group_id = g.id) as student_count
            FROM groups g
            JOIN teachers t ON g.teacher_id = t.id
            JOIN users u ON t.user_id = u.id
        ");
        break;
        
    default:
        response('error', 'Invalid user type');
}

// Execute query
$stmt->execute();
$result = $stmt->get_result();

// Fetch all groups
while ($row = $result->fetch_assoc()) {
    $groups[] = $row;
}

// Return success response with groups data
response('success', 'Groups retrieved successfully', $groups);
