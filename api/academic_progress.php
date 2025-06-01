<?php
// filepath: /opt/lampp/htdocs/quranic/api/academic_progress.php

// Include config and token validation
require_once 'config.php';
require_once 'validate_token.php';

// Handle different HTTP methods
$method = $_SERVER['REQUEST_METHOD'];

// Validate token and get user data
$userData = validateToken();
$userId = $userData['user_id'];
$userType = $userData['user_type'];

// Connect to database
$conn = getDBConnection();

switch ($method) {
    case 'GET':
        handleGetProgress($conn, $userId, $userType);
        break;
    case 'POST':
        handlePostProgress($conn, $userId, $userType);
        break;
    default:
        response('error', 'Method not allowed');
}

/**
 * Handle GET request to retrieve academic progress records
 */
function handleGetProgress($conn, $userId, $userType) {
    // Get query parameters
    $studentId = isset($_GET['student_id']) ? intval($_GET['student_id']) : null;
    $groupId = isset($_GET['group_id']) ? intval($_GET['group_id']) : null;
    $date = isset($_GET['date']) ? sanitizeInput($_GET['date']) : null;
    $month = isset($_GET['month']) ? sanitizeInput($_GET['month']) : null;
    
    // Validate parameters based on user type
    if ($userType === 'student') {
        // Get the student ID for the current user
        $stmt = $conn->prepare("SELECT id FROM students WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            response('error', 'Student not found');
        }
        
        $student = $result->fetch_assoc();
        $studentId = $student['id'];
    } elseif ($userType === 'teacher' && $groupId === null) {
        // For teachers, if no group ID is provided, get their assigned groups
        $stmt = $conn->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            response('error', 'Teacher not found');
        }
        
        $teacher = $result->fetch_assoc();
        $teacherId = $teacher['id'];
        
        // Get groups assigned to this teacher
        $stmt = $conn->prepare("SELECT id FROM groups WHERE teacher_id = ?");
        $stmt->bind_param("i", $teacherId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $groupIds = [];
        while ($row = $result->fetch_assoc()) {
            $groupIds[] = $row['id'];
        }
        
        if (empty($groupIds)) {
            response('success', 'No groups assigned to this teacher', []);
        }
    }
    
    // Build query based on parameters
    $query = "
        SELECT ap.id, ap.sourah, ap.ayah, ap.evaluation, ap.progress_type, ap.date, ap.note,
               g.group_name, g.id as group_id,
               CONCAT(u.first_name, ' ', u.last_name) as student_name,
               s.id as student_id
        FROM academic_progress ap
        JOIN groups g ON ap.group_id = g.id
        JOIN students s ON ap.student_id = s.id
        JOIN users u ON s.user_id = u.id
        WHERE 1=1
    ";
    
    $params = [];
    $types = "";
    
    if ($studentId !== null) {
        $query .= " AND ap.student_id = ?";
        $params[] = $studentId;
        $types .= "i";
    }
    
    if ($groupId !== null) {
        $query .= " AND ap.group_id = ?";
        $params[] = $groupId;
        $types .= "i";
    } elseif (isset($groupIds) && !empty($groupIds)) {
        $placeholders = str_repeat('?,', count($groupIds) - 1) . '?';
        $query .= " AND ap.group_id IN ($placeholders)";
        foreach ($groupIds as $id) {
            $params[] = $id;
            $types .= "i";
        }
    }
    
    if ($date !== null) {
        $query .= " AND ap.date = ?";
        $params[] = $date;
        $types .= "s";
    }
    
    if ($month !== null) {
        $query .= " AND MONTH(ap.date) = ? AND YEAR(ap.date) = ?";
        list($year, $month) = explode('-', $month);
        $params[] = $month;
        $params[] = $year;
        $types .= "ii";
    }
    
    // Add order by clause
    $query .= " ORDER BY ap.date DESC, g.group_name, u.first_name, u.last_name";
    
    // Prepare and execute statement
    $stmt = $conn->prepare($query);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch all progress records
    $progress = [];
    while ($row = $result->fetch_assoc()) {
        $progress[] = $row;
    }
    
    // Return success response with progress data
    response('success', 'Academic progress records retrieved successfully', $progress);
}

/**
 * Handle POST request to create/update academic progress records
 */
function handlePostProgress($conn, $userId, $userType) {
    // Only teachers and admins can create/update academic progress records
    if ($userType !== 'teacher' && $userType !== 'admin' && $userType !== 'super_admin') {
        response('error', 'Permission denied');
    }
    
    // Get the posted data
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate required fields
    if (!isset($data['student_id']) || !isset($data['group_id']) || 
        !isset($data['sourah']) || !isset($data['ayah']) || 
        !isset($data['evaluation']) || !isset($data['progress_type'])) {
        response('error', 'Missing required fields');
    }
    
    $studentId = intval($data['student_id']);
    $groupId = intval($data['group_id']);
    $sourah = sanitizeInput($data['sourah']);
    $ayah = sanitizeInput($data['ayah']);
    $evaluation = sanitizeInput($data['evaluation']);
    $progressType = sanitizeInput($data['progress_type']);
    $note = isset($data['note']) ? sanitizeInput($data['note']) : '';
    $date = isset($data['date']) ? sanitizeInput($data['date']) : date('Y-m-d');
    
    // Validate evaluation
    $validEvaluations = ['ممتاز', 'جيد', 'متوسط', 'يحتاج مراجعة'];
    if (!in_array($evaluation, $validEvaluations)) {
        response('error', 'Invalid evaluation value');
    }
    
    // Validate progress type
    $validProgressTypes = ['حفظ جديد', 'مراجعة', '', ''];
    if (!in_array($progressType, $validProgressTypes)) {
        response('error', 'Invalid progress type value');
    }
    
    // Get teacher ID if user is a teacher
    if ($userType === 'teacher') {
        $stmt = $conn->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            response('error', 'Teacher not found');
        }
        
        $teacher = $result->fetch_assoc();
        $teacherId = $teacher['id'];
        
        // Verify teacher is assigned to the group
        $stmt = $conn->prepare("SELECT id FROM groups WHERE id = ? AND teacher_id = ?");
        $stmt->bind_param("ii", $groupId, $teacherId);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows === 0) {
            response('error', 'You are not assigned to this group');
        }
    }
    
    // Verify student is in the group
    $stmt = $conn->prepare("
        SELECT id FROM student_groups 
        WHERE student_id = ? AND group_id = ?
    ");
    $stmt->bind_param("ii", $studentId, $groupId);
    $stmt->execute();
    
    if ($stmt->get_result()->num_rows === 0) {
        response('error', 'Student is not in this group');
    }
    
    // Insert new academic progress record
    $stmt = $conn->prepare("
        INSERT INTO academic_progress (student_id, group_id, sourah, ayah, evaluation, progress_type, date, note)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->bind_param("iissssss", 
        $studentId, $groupId, $sourah, $ayah, $evaluation, $progressType, $date, $note
    );
    
    if ($stmt->execute()) {
        $progressId = $conn->insert_id;
        response('success', 'Academic progress record created successfully', ['id' => $progressId]);
    } else {
        response('error', 'Failed to create academic progress record: ' . $stmt->error);
    }
}
