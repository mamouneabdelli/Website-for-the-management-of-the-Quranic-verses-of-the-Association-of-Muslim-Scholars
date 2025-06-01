<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
 
//print_r($_SESSION);
if (isset($_SESSION['login_in']) && $_SESSION['login_in'] == true) {
    $showPopup = true;
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جمعية العلماء المسلمين</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
    <!-- Font Awesome Library -->
    <link rel="stylesheet" href="CSS/all.min.css" />
    
</head>

<body>
    <!-- Nav Bar -->
    <nav class="nav-bar">
        <div class="logo">
            <img src="<?= $config['app_url'] ?>/img/logo.png" alt="Logo جمعية العلماء المسلمين">
        </div>
        <div class="menu">
            <a href="index.php" class="menu-item">الرئيسية</a> <!-- هنا ربط تاع صفحات مع بعض    -->
            <a href="برنامجنا.php" class="menu-item">عن البرنامج</a>
            <a href="contact.php" class="menu-item">اتصل بنا</a>
            <a href="قضيتنا.php" class="menu-item">قضيتنا</a>
        </div>
        <div class="cta-button">
            <?php if (isset($_SESSION['logen_in'])) { ?>
                <a href="login.php" class="login-button" aria-disabled="true" role="button">
                    <i class="fas fa-lock"></i>
                    <span>تسجيل الدخول</span>
                </a>
            <?php } else { ?>
                <a href="signup.php">سجّل وابدأ رحلتك العلمية</a>
                <a href="login.php">تسجيل الدخول</a>
            <?php } ?>
        </div>
    </nav>