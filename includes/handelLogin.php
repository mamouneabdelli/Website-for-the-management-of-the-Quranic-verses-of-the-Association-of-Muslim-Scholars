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
        $student = new Student(
            $email,
            $password,
            $db
        );
        
        $loginResult = $student->login();
        if ($loginResult) {
            $_SESSION['logged_in'] = true;  
            $_SESSION['name'] = $loginResult['first_name'];  
            header("Location: /quranic/admin/dashboradstudent.php");
            exit();
        } else {
            $errors['user'] = "كلمة السر او الايميل غير صالح";  
        }
    }
}
