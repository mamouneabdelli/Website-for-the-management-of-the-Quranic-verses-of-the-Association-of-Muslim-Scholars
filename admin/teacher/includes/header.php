<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors",1);

// التحقق مما إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['login_in']) || $_SESSION['login_in'] !== true || !isset($_SESSION['teacher_id']) || $_SESSION['user_type'] !== 'teacher') {
    header("Location: /quranic/login.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأستاذ</title>
    <style>
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="welcome-msg">
            أهلا بك يا <span><?= $_SESSION['name'] ?></span>
        </div>
        <div class="header-icons">
            <i class="fas fa-bell"></i>
            <i class="fas fa-envelope"></i>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="../../img/شعار.png" alt="جمعية العلماء المسلمين">
                <p>جمعية العلماء المسلمين الجزائريين</p>
            </div>
            <ul class="sidebar-menu">
                <li style="background-color:#B0E4C4;">
                    <a href="index.php" >لوحة التحكم</a>
                </li>
                <li>
                    <a href="attendance.php">الحضور والغياب</a>
                </li>
                <li>
                    <a href="save.php">الحفظ والمراجعة</a>
                </li>
                <li >
                    <a href="report.php">إرسال تقرير</a>
                </li>
            </ul>
            <div class="register-btn">
                <i class="fas fa-arrow-left"></i> <a href="logout.php">تسجيل الخروج</a>
            </div>
        </div>