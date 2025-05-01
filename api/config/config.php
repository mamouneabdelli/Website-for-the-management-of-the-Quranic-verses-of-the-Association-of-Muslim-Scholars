<?php
// Show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Set default timezone
date_default_timezone_set('Asia/Riyadh');

// API URL
$api_url = "http://localhost/quranic/api/";

// JWT Secret key
$jwt_secret = "your-secret-key-here";

// CORS headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
?> 