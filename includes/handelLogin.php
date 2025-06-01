<?php
session_start();
require_once __DIR__ . "/../classes/Student.php";
require_once __DIR__ . "/../classes/DBConnection.php";

function filterString($field)
{
    $field = filter_var(trim($field), FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($field))
        return false;
    else
        return $field;
}

function filterEmail($field)
{
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL))
        return $field;
    else
        return false;
}

$errors = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'user' => ''
];

$email = $password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; $password = $_POST['password'];
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filterEmail($email);
        if (!$email)
            $errors['email'] = "الايميل غير صالح";
    } else {
        if (empty($_POST['email'])) $errors['email'] = "الاميل مطلوب";
        if (empty($_POST['password'])) $errors['password'] = "كلمة السر مطلوبة";
    }
    
    if (!$errors['email'] && !$errors['password']) {
        $db = DBConnection::getConnection()->getDb();
        
        // البحث عن المستخدم في قاعدة البيانات
        $query = $db->prepare("SELECT * FROM users WHERE email=?");
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);
        
        // التحقق من وجود المستخدم
        if ($user && password_verify($password, $user['password'])) {
            // تخزين معلومات المستخدم في الجلسة
            $_SESSION['login_in'] = true;  
            $_SESSION['name'] = $user['first_name'] . " " . $user['last_name'];
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_type'] = $user['user_type'];
            
            // توجيه المستخدم حسب نوعه
            switch ($user['user_type']) {
                case 'student':
                    // الحصول على معرف الطالب
                    $query = $db->prepare("SELECT id FROM students WHERE user_id = ?");
                    $query->execute([$user['id']]);
                    $student = $query->fetch(PDO::FETCH_ASSOC);
                    if ($student) {
                        $_SESSION['student_id'] = $student['id'];
                    }
                    header("Location: /quranic/admin/student");
                    break;
                    
                case 'teacher':
                    // الحصول على معرف المعلم
                    $query = $db->prepare("SELECT id FROM teachers WHERE user_id = ?");
                    $query->execute([$user['id']]);
                    $teacher = $query->fetch(PDO::FETCH_ASSOC);
                    if ($teacher) {
                        $_SESSION['teacher_id'] = $teacher['id'];
                    }
                    header("Location: /quranic/admin/teacher");
                    break;
                    
                case 'admin':
                    // الحصول على معرف المشرف
                    $query = $db->prepare("SELECT id FROM supervisors WHERE user_id = ?");
                    $query->execute([$user['id']]);
                    $supervisor = $query->fetch(PDO::FETCH_ASSOC);
                    if ($supervisor) {
                        $_SESSION['supervisor_id'] = $supervisor['id'];
                    }
                    header("Location: /quranic/admin");
                    break;
                    
                case 'super_admin':
                    // الحصول على معرف المدير
                    $query = $db->prepare("SELECT id FROM super_admin WHERE user_id = ?");
                    $query->execute([$user['id']]);
                    $super_admin = $query->fetch(PDO::FETCH_ASSOC);
                    if ($super_admin) {
                        $_SESSION['super_admin_id'] = $super_admin['id'];
                    }
                    header("Location: /quranic/admin");
                    break;
                
                default:
                    // في حالة عدم وجود نوع محدد، يتم توجيه المستخدم إلى الصفحة الرئيسية
                    header("Location: /quranic");
                    break;
            }
            exit();
        } else {
            $errors['user'] = "كلمة السر او الايميل غير صالح";  
        }
    }
}
