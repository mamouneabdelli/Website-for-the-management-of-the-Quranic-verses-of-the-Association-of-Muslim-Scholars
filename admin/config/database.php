<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'quranic_management_system';

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($host, $username, $password, $database);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// تعيين ترميز الاتصال إلى UTF-8
$conn->set_charset("utf8mb4");
?> 