<?php
// filepath: /opt/lampp/htdocs/quranic/api/attendance.php

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
        handleGetAttendance($conn, $userId, $userType);
        break;
    case 'POST':
        handlePostAttendance($conn, $userId, $userType);
        break;
    default:
        response('error', 'Method not allowed');
}

/**
 * Handle GET request to retrieve attendance records
 */
function handleGetAttendance($conn, $userId, $userType) {
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
        response('error', 'Group ID is required for teachers');
    }
    
    // Build query based on parameters
    $query = "
        SELECT a.id, a.date, a.status, a.note, a.is_excused,
               g.group_name, g.id as group_id,
               CONCAT(u.first_name, ' ', u.last_name) as student_name,
               s.id as student_id
        FROM attendance a
        JOIN groups g ON a.group_id = g.id
        JOIN students s ON a.student_id = s.id
        JOIN users u ON s.user_id = u.id
        WHERE 1=1
    ";
    
    $params = [];
    $types = "";
    
    if ($studentId !== null) {
        $query .= " AND a.student_id = ?";
        $params[] = $studentId;
        $types .= "i";
    }
    
    if ($groupId !== null) {
        $query .= " AND a.group_id = ?";
        $params[] = $groupId;
        $types .= "i";
    }
    
    if ($date !== null) {
        $query .= " AND a.date = ?";
        $params[] = $date;
        $types .= "s";
    }
    
    if ($month !== null) {
        $query .= " AND MONTH(a.date) = ? AND YEAR(a.date) = ?";
        list($year, $month) = explode('-', $month);
        $params[] = $month;
        $params[] = $year;
        $types .= "ii";
    }
    
    // Add order by clause
    $query .= " ORDER BY a.date DESC, g.group_name, u.first_name, u.last_name";
    
    // Prepare and execute statement
    $stmt = $conn->prepare($query);
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch all attendance records
    $attendance = [];
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
    
    // Return success response with attendance data
    response('success', 'Attendance records retrieved successfully', $attendance);
}

/**
 * Handle POST request to create/update attendance records
 */
function handlePostAttendance($conn, $userId, $userType) {
    // Only teachers and admins can create/update attendance records
    if ($userType !== 'teacher' && $userType !== 'admin' && $userType !== 'super_admin') {
        response('error', 'Permission denied');
    }
    
    // Get the posted data
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Validate required fields
    if (!isset($data['group_id']) || !isset($data['records'])) {
        response('error', 'Group ID and attendance records are required');
    }
    
    $groupId = intval($data['group_id']);
    $records = $data['records'];
    $date = isset($data['date']) ? sanitizeInput($data['date']) : date('Y-m-d');
    
    // Get teacher ID if user is a teacher
    $teacherId = null;
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
    
    // Begin transaction
    $conn->begin_transaction();
    
    try {
        // For each attendance record
        foreach ($records as $record) {
            // Validate required fields
            if (!isset($record['student_id']) || !isset($record['status'])) {
                throw new Exception('Student ID and status are required for each record');
            }
            
            $studentId = intval($record['student_id']);
            $status = sanitizeInput($record['status']);
            $note = isset($record['note']) ? sanitizeInput($record['note']) : null;
            $isExcused = isset($record['is_excused']) ? (int)$record['is_excused'] : null;
            
            // Validate status
            if (!in_array($status, ['حاضر', 'غائب', 'متأخر'])) {
                throw new Exception('Invalid status value');
            }
            
            // Check if attendance record already exists for this student, group and date
            $stmt = $conn->prepare("
                SELECT id FROM attendance 
                WHERE student_id = ? AND group_id = ? AND date = ?
            ");
            $stmt->bind_param("iis", $studentId, $groupId, $date);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Update existing record
                $attendanceId = $result->fetch_assoc()['id'];
                $stmt = $conn->prepare("
                    UPDATE attendance 
                    SET status = ?, note = ?, is_excused = ? 
                    WHERE id = ?
                ");
                $stmt->bind_param("ssii", $status, $note, $isExcused, $attendanceId);
            } else {
                // Create new record
                $stmt = $conn->prepare("
                    INSERT INTO attendance (student_id, group_id, date, status, note, is_excused, created_by) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("iisssii", $studentId, $groupId, $date, $status, $note, $isExcused, $teacherId);
            }
            
            $stmt->execute();
        }
        
        // Commit transaction
        $conn->commit();
        
        // Return success response
        response('success', 'Attendance records saved successfully');
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        response('error', 'Failed to save attendance records: ' . $e->getMessage());
    }
}
