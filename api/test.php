<?php
// filepath: /opt/lampp/htdocs/quranic/api/test.php

// Include config file
require_once 'config.php';

echo "<h1>اختبار واجهة برمجة التطبيقات لنظام إدارة المدارس القرآنية</h1>";

// اختبار الاتصال بقاعدة البيانات
echo "<h2>اختبار الاتصال بقاعدة البيانات:</h2>";
try {
    $conn = getDBConnection();
    echo "<p style='color:green'>تم الاتصال بقاعدة البيانات بنجاح!</p>";
    
    // التحقق من وجود بيانات المستخدمين
    $query = "SELECT COUNT(*) as count FROM users";
    $result = $conn->query($query);
    $userCount = $result->fetch_assoc()['count'];
    echo "<p>عدد المستخدمين في قاعدة البيانات: $userCount</p>";
    
    // عرض بعض المستخدمين
    $query = "SELECT id, email, first_name, last_name, user_type FROM users LIMIT 5";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>رقم</th><th>البريد الإلكتروني</th><th>الاسم</th><th>اللقب</th><th>نوع المستخدم</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['first_name'] . "</td>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['user_type'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>فشل الاتصال بقاعدة البيانات: " . $e->getMessage() . "</p>";
}

// تلميحات لاستخدام Postman
echo "<h2>تعليمات لاختبار الـ API باستخدام Postman:</h2>";

echo "<h3>1. تسجيل الدخول:</h3>";
echo "<ul>";
echo "<li>الطريقة: POST</li>";
echo "<li>الرابط: <code>http://localhost/quranic/api/login.php</code></li>";
echo "<li>نوع البيانات: JSON</li>";
echo "<li>محتوى الطلب:";
echo "<pre>" . json_encode([
    "email" => "brahmialokman16@gmail.com",
    "password" => "12345678"
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre></li>";
echo "<li>انسخ التوكن من الاستجابة للاستخدام في الطلبات اللاحقة</li>";
echo "</ul>";

echo "<h3>2. الملف الشخصي للمستخدم:</h3>";
echo "<ul>";
echo "<li>الطريقة: GET</li>";
echo "<li>الرابط: <code>http://localhost/quranic/api/user_profile.php</code></li>";
echo "<li>الرؤوس (Headers):</li>";
echo "<li><code>Authorization: Bearer YOUR_TOKEN</code></li>";
echo "</ul>";

echo "<h3>3. الحصول على المجموعات:</h3>";
echo "<ul>";
echo "<li>الطريقة: GET</li>";
echo "<li>الرابط: <code>http://localhost/quranic/api/groups.php</code></li>";
echo "<li>الرؤوس (Headers):</li>";
echo "<li><code>Authorization: Bearer YOUR_TOKEN</code></li>";
echo "</ul>";

echo "<h3>4. الحصول على سجلات الحضور:</h3>";
echo "<ul>";
echo "<li>الطريقة: GET</li>";
echo "<li>الرابط: <code>http://localhost/quranic/api/attendance.php?group_id=8</code></li>";
echo "<li>الرؤوس (Headers):</li>";
echo "<li><code>Authorization: Bearer YOUR_TOKEN</code></li>";
echo "</ul>";

echo "<h3>5. إضافة سجل حضور:</h3>";
echo "<ul>";
echo "<li>الطريقة: POST</li>";
echo "<li>الرابط: <code>http://localhost/quranic/api/attendance.php</code></li>";
echo "<li>الرؤوس (Headers):</li>";
echo "<li><code>Authorization: Bearer YOUR_TOKEN</code></li>";
echo "<li>محتوى الطلب:";
echo "<pre>" . json_encode([
    "group_id" => 8,
    "date" => "2025-06-01",
    "records" => [
        [
            "student_id" => 11,
            "status" => "حاضر",
            "note" => "حضر في الوقت المحدد"
        ]
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "</pre></li>";
echo "</ul>";

// إنشاء توكن تجريبي للاستخدام المباشر
echo "<h2>توكن تجريبي للاختبار:</h2>";
$conn = getDBConnection();
$query = "SELECT id, email, user_type FROM users LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $userId = $user['id'];
    $userEmail = $user['email'];
    $userType = $user['user_type'];
    
    // إنشاء توكن تجريبي
    $timestamp = time();
    $randomString = bin2hex(random_bytes(16));
    $token = $userId . ':' . $timestamp . ':' . $randomString;
    
    echo "<p>توكن تجريبي للمستخدم: $userEmail (ID: $userId, النوع: $userType)</p>";
    echo "<div style='background-color: #f5f5f5; padding: 10px; border-radius: 5px; word-break: break-all;'>";
    echo "$token";
    echo "</div>";
    echo "<p>استخدم هذا التوكن في رأس الطلب كالتالي:</p>";
    echo "<code>Authorization: Bearer $token</code>";
}

echo "<hr>";
echo "<p>ملاحظة: هذا الملف للاختبار فقط. في البيئة الإنتاجية، يجب إزالته أو تعطيله.</p>";
?>
