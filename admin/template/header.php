<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../classes/DBConnection.php';

$db = DBConnection::getConnection()->getDb();



require_once __DIR__ .'/../../config/app.php';
?>



<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المسؤول - جمعية العلماء المسلمين</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<div class="header">
    <div class="welcome-msg">
        أهلا بك يا <span>المدير أحمد</span>
    </div>
    <div class="header-icons">
        <i class="fas fa-bell"></i>
        <i class="fas fa-envelope"></i>
        <i class="fas fa-cog"></i>
    </div>
</div>

<div class="container">
    <div class="sidebar">
        <div class="logo">
            <img src="<?= $config['app_url'] ?>/img/logo.png" alt="جمعية العلماء المسلمين">
            <p>جمعية العلماء المسلمين الجزائريين</p>
        </div>
        <ul class="sidebar-menu">
            <li style="background-color:#B0E4C4;" class="active">
                <a href="index.php">لوحة التحكم</a>
            </li>
            <li>
                <a href="admin-users.php">إدارة المستخدمين</a>
            </li>
            <li>
                <a href="admin-teachers.php">إدارة الأساتذة</a>
            </li>
            <li>
                <a href="admin-students.php">إدارة الطلاب</a>
            </li>
            <li>
                <a href="admin-sessions.php">إدارة الحلقات</a>
            </li>
            <li>
                <a href="admin-reports.php">الرسائل والإحصائيات</a>
            </li>
            <li>
                <a href="admin-reports.php">ادارة البرامج</a>
            </li>
            <li>
                <a href="admin-settings.php">إعدادات النظام</a>
            </li>
        </ul>
        <div class="register-btn">
            <i class="fas fa-arrow-left"></i> تسجيل الخروج
        </div>
    </div>