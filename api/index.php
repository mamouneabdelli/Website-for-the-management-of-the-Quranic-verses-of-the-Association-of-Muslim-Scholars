<?php
// filepath: /opt/lampp/htdocs/quranic/api/index.php

// Include config file
require_once 'config.php';

// Set up response
header('Content-Type: application/json; charset=UTF-8');

// API information
$apiInfo = [
    'name' => 'Quranic Management System API',
    'version' => '1.0.0',
    'description' => 'API for Quranic Management System Mobile Application',
    'endpoints' => [
        [
            'path' => '/api/login.php',
            'method' => 'POST',
            'description' => 'User authentication',
            'parameters' => [
                'email' => 'User email',
                'password' => 'User password'
            ]
        ],
        [
            'path' => '/api/register.php',
            'method' => 'POST',
            'description' => 'User registration',
            'parameters' => [
                'email' => 'User email',
                'password' => 'User password',
                'first_name' => 'User first name',
                'last_name' => 'User last name',
                'gender' => 'User gender (male/female)',
                'phone' => 'User phone number',
                'date_of_birth' => 'User date of birth',
                'place_of_birth' => 'User place of birth',
                'address' => 'User address',
                'academic_level' => 'User academic level',
                'user_type' => 'User type (student/teacher/admin)'
            ]
        ],
        [
            'path' => '/api/user_profile.php',
            'method' => 'GET',
            'description' => 'Get user profile information',
            'parameters' => [],
            'authentication' => 'Bearer token required'
        ],
        [
            'path' => '/api/groups.php',
            'method' => 'GET',
            'description' => 'Get groups information',
            'parameters' => [],
            'authentication' => 'Bearer token required'
        ],
        [
            'path' => '/api/attendance.php',
            'method' => 'GET',
            'description' => 'Get attendance records',
            'parameters' => [
                'student_id' => 'Student ID (optional)',
                'group_id' => 'Group ID (optional)',
                'date' => 'Date (optional)',
                'month' => 'Month in YYYY-MM format (optional)'
            ],
            'authentication' => 'Bearer token required'
        ],
        [
            'path' => '/api/attendance.php',
            'method' => 'POST',
            'description' => 'Create/update attendance records',
            'parameters' => [
                'group_id' => 'Group ID',
                'date' => 'Date (optional, defaults to current date)',
                'records' => 'Array of attendance records'
            ],
            'authentication' => 'Bearer token required (teacher/admin only)'
        ],
        [
            'path' => '/api/academic_progress.php',
            'method' => 'GET',
            'description' => 'Get academic progress records',
            'parameters' => [
                'student_id' => 'Student ID (optional)',
                'group_id' => 'Group ID (optional)',
                'date' => 'Date (optional)',
                'month' => 'Month in YYYY-MM format (optional)'
            ],
            'authentication' => 'Bearer token required'
        ],
        [
            'path' => '/api/academic_progress.php',
            'method' => 'POST',
            'description' => 'Create academic progress record',
            'parameters' => [
                'student_id' => 'Student ID',
                'group_id' => 'Group ID',
                'sourah' => 'Sourah name',
                'ayah' => 'Ayah reference',
                'evaluation' => 'Evaluation (ممتاز/جيد/متوسط/يحتاج مراجعة)',
                'progress_type' => 'Progress type (حفظ جديد/مراجعة)',
                'date' => 'Date (optional, defaults to current date)',
                'note' => 'Note (optional)'
            ],
            'authentication' => 'Bearer token required (teacher/admin only)'
        ]
    ],
    'authentication' => 'Most endpoints require authentication using a Bearer token. ' .
                        'The token is obtained from the login endpoint and should be ' .
                        'included in the Authorization header of subsequent requests.',
    'token_format' => 'Authorization: Bearer {token}'
];

// Output API information
echo json_encode($apiInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
