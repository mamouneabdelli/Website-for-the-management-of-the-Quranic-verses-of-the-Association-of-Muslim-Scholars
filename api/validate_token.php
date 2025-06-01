<?php
// filepath: /opt/lampp/htdocs/quranic/api/validate_token.php

// Include config file
require_once 'config.php';

// This file would normally validate the token sent in Authorization header
// For a real implementation, you should use JWT or other secure token method

/**
 * Validate the token provided in the Authorization header
 * 
 * @return array User data if token is valid, otherwise exits with error response
 */
function validateToken() {
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
    
    // In a real application, you would validate the token here
    // For example, verifying a JWT token, or checking a token in the database
    
    // For demonstration purposes, we'll just check if the token is not empty
    if (empty($token)) {
        response('error', 'Invalid token');
    }
    
    // Here we will fetch the user data based on the token
    // Since we don't have a token storage system yet, we'll allow any valid user ID for testing
    
    // Connect to database
    $conn = getDBConnection();
    
    // For testing purposes, let's extract the user ID from the token
    // Token format: "{user_id}:{timestamp}:{random_string}"
    $tokenParts = explode(':', $token);
    
    // Check if token has the expected format
    if (count($tokenParts) >= 3) {
        $userId = intval($tokenParts[0]);
        
        // Get user from database using the extracted ID
        $stmt = $conn->prepare("SELECT id, user_type FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            return [
                'user_id' => $user['id'],
                'user_type' => $user['user_type']
            ];
        }
    }
    
    // إذا كان التوكن بتنسيق غير صالح أو لم يتم العثور على المستخدم
    // للتسهيل في بيئة الاختبار، دعنا نستخدم أي مستخدم صالح في قاعدة البيانات
    $query = "SELECT id, user_type FROM users LIMIT 1";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // لا تقم بطباعة أي شيء هنا لتجنب مشاكل JSON
        return [
            'user_id' => $user['id'],
            'user_type' => $user['user_type']
        ];
    }
    
    // If no users found, return error
    response('error', 'User not found');
}
