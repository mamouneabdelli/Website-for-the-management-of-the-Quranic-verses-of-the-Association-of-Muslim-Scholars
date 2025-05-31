<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../classes/DBConnection.php';

$db = DBConnection::getConnection()->getDb();



require_once __DIR__ .'/../../config/app.php';
?>


<style>
     /* Reset and Base Styles */
 * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Arial, sans-serif;
}

body {
    background-color: #F2F9FF;
    color: #333;
}

/* Main Layout */
.container {
    display: flex;
    min-height: 100vh;
}

/* Header Styles */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: white;
    border-bottom: 1px solid #e0e0e0;
}

.welcome-msg {
    color: #555;
    font-weight: bold;
    font-size: 16px;
}

.welcome-msg span {
    color: #000;
}

.header-icons {
    display: flex;
    gap: 15px;
}

.header-icons i {
    font-size: 20px;
    color: #555;
}

/* Sidebar Styles */
.sidebar {
    width: 280px;
    background-color: white;
    padding: 15px 0;
    border-left: 1px solid #e0e0e0;
}

.logo {
    text-align: center;
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 15px;
}

.logo img {
    width: 120px;
    height: 90px;
    border-radius: 50%;
    background-color: #FFFFFF;
}

.logo p {
    font-size: 14px;
    margin-top: 8px;
    color: #333;
    font-weight: 600;
}

.sidebar-menu {
    list-style: none;
    padding: 0 15px;
}

.sidebar-menu li {
    background-color: #E6F6EC;
    border-radius: 8px;
    padding: 12px 15px;
    margin-bottom: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

.sidebar-menu li a {
    color: black;
    text-decoration: none;
}

.sidebar-menu li:hover {
    background-color: #00A841;
    color: white;
}

.sidebar-menu li.active {
    background-color: #E6F6EC;
    color: #00A841;
    border-right: 4px solid #00A841;
}

.register-btn {
    background-color: #000;
    color: white;
    padding: 12px;
    text-align: center;
    margin: 15px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
}
</style>

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
            <li class="<?= $index ?? "" ?>">
                <a href="index.php">لوحة التحكم</a>
            </li>
            <li class="<?= $ac_user ?? "" ?>">
                <a href="admin-users.php" >إدارة المستخدمين</a>
            </li>
            <li class="<?= $ac_teacher ?? "" ?>">
                <a href="admin-teachers.php" >إدارة الأساتذة</a>
            </li>
            <li class="<?= $ac_student ?? "" ?>">
                <a href="admin-students.php" >إدارة الطلاب</a>
            </li>
            <li class="<?= $ac_session ?? "" ?>">
                <a href="admin-sessions.php" >إدارة الحلقات</a>
            </li>
            <li class="<?= $ac_message ?? "" ?>">
                <a href="admin-reports.php" >الرسائل والإحصائيات</a>
            </li>
            <li class="<?= $ac_programs ?? "" ?>" >
                <a href="admin-programs.php">ادارة جداول الحلقات الأسبوعية</a>
            </li>
            <li>
                <a href="admin-settings.php">إعدادات النظام</a>
            </li>
        </ul>
        <div class="register-btn">
            <i class="fas fa-arrow-left"></i> تسجيل الخروج
        </div>
    </div>