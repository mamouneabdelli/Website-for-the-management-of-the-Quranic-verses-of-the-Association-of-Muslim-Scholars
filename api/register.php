<?php
// filepath: /opt/lampp/htdocs/quranic/api/register.php

// Include config file
require_once 'config.php';

// Only handle POST requests for registration
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    response('error', 'Only POST method is allowed');
}

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);

// Check if the data is valid
$requiredFields = [
    'email', 'password', 'first_name', 'last_name', 'gender', 
    'phone', 'date_of_birth', 'place_of_birth', 'address', 
    'academic_level', 'user_type'
];

foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty($data[$field])) {
        response('error', "Field '$field' is required");
    }
}

// Sanitize input
$email = sanitizeInput($data['email']);
$password = $data['password']; // Will be hashed later
$firstName = sanitizeInput($data['first_name']);
$lastName = sanitizeInput($data['last_name']);
$gender = sanitizeInput($data['gender']);
$phone = sanitizeInput($data['phone']);
$dateOfBirth = sanitizeInput($data['date_of_birth']);
$placeOfBirth = sanitizeInput($data['place_of_birth']);
$address = sanitizeInput($data['address']);
$academicLevel = sanitizeInput($data['academic_level']);
$userType = sanitizeInput($data['user_type']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response('error', 'Invalid email format');
}

// Validate gender
if (!in_array($gender, ['male', 'female'])) {
    response('error', 'Gender must be either male or female');
}

// Validate user type
if (!in_array($userType, ['student', 'teacher', 'admin', 'super_admin'])) {
    response('error', 'Invalid user type');
}

// Connect to database
$conn = getDBConnection();

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    response('error', 'Email already exists');
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Begin transaction
$conn->begin_transaction();

try {
    // Insert user data
    $stmt = $conn->prepare("
        INSERT INTO users (email, first_name, last_name, password, gender, phone, 
                          date_of_birth, place_of_birth, address, academic_level, user_type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->bind_param("sssssssssss", 
        $email, $firstName, $lastName, $hashedPassword, $gender, 
        $phone, $dateOfBirth, $placeOfBirth, $address, $academicLevel, $userType
    );
    
    $stmt->execute();
    
    // Get the new user ID
    $userId = $conn->insert_id;
    
    // Insert additional data based on user type
    switch ($userType) {
        case 'student':
            // Check if additional required fields are provided
            if (!isset($data['parent_name'])) {
                throw new Exception("Parent name is required for student registration");
            }
            
            $parentName = sanitizeInput($data['parent_name']);
            $studentCode = isset($data['student_code']) ? sanitizeInput($data['student_code']) : '';
            $notes = isset($data['notes']) ? sanitizeInput($data['notes']) : '';
            
            $stmt = $conn->prepare("
                INSERT INTO students (user_id, student_code, parent_name, notes, registered) 
                VALUES (?, ?, ?, ?, 1)
            ");
            
            $stmt->bind_param("isss", $userId, $studentCode, $parentName, $notes);
            $stmt->execute();
            break;
            
        case 'teacher':
            // Check if additional required fields are provided
            $specialization = isset($data['specialization']) ? sanitizeInput($data['specialization']) : '';
            $qualification = isset($data['qualification']) ? sanitizeInput($data['qualification']) : '';
            $notes = isset($data['notes']) ? sanitizeInput($data['notes']) : '';
            
            $stmt = $conn->prepare("
                INSERT INTO teachers (user_id, specialization, qualification, employment_date, notes) 
                VALUES (?, ?, ?, CURRENT_DATE, ?)
            ");
            
            $stmt->bind_param("isss", $userId, $specialization, $qualification, $notes);
            $stmt->execute();
            break;
            
        case 'admin':
            $department = isset($data['department']) ? sanitizeInput($data['department']) : null;
            $position = isset($data['position']) ? sanitizeInput($data['position']) : 'أمين المدرسة';
            $responsibilities = isset($data['responsibilities']) ? sanitizeInput($data['responsibilities']) : null;
            
            $stmt = $conn->prepare("
                INSERT INTO supervisors (user_id, employment_date, department, position, responsibilities) 
                VALUES (?, CURRENT_DATE, ?, ?, ?)
            ");
            
            $stmt->bind_param("isss", $userId, $department, $position, $responsibilities);
            $stmt->execute();
            break;
    }
    
    // Commit transaction
    $conn->commit();
    
    // Return success response
    response('success', 'User registered successfully', ['user_id' => $userId]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    response('error', 'Registration failed: ' . $e->getMessage());
}
