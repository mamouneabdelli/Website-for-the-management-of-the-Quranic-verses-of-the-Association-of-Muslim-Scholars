<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم طالب المدرسة القرآنية</title>
    <link rel="stylesheet" href="../CSS/dashboardStudent.css">
</head>

<body>
    <div class="page-layout">
        <!-- Sidebar from Image 2 -->
        <div class="color">
            <div class="sidebar">
                <div class="logo-container">
                    <img src="../img/d21ff0b5c94ca27dab2ad0f90de39de1.png" alt="Association Logo" class="association-logo" />
                    <div class="association-name">جمعية العلماء المسلمين الجزائريين</div>
                </div>

                <button class="sidebar-btn">لوحة الاحصائيات</button>
                <button class="sidebar-btn">علامات الاختبارات</button>
                <button class="sidebar-btn">الاشعارات</button>
                <button class="sidebar-btn">ارسل رسالة</button>
                <button class="sidebar-btn login-sidebar-btn">
                    <span>تسجيل الدخول</span>
                    <i class="icon">→</i>
                </button>
            </div>
        </div>

        <div class="main-content">
            <div class="container">
                <!-- Header Section -->
                <div class="header">
                    <div class="icons-section">
                        <div class="welcome-text">
                            <span>👋 أهلا بك يا <?= $_SESSION['name'] ?>، عودا حميدا!</span>
                        </div>

                        <div class="icon">✉️</div>
                        <div class="icon">🔔</div>
                    </div>
                    <button class="login-btn">
                        <span>تسجيل الدخول</span>
                        <i class="icon">→</i>
                    </button>
                </div>

                <!-- Metrics Section -->
                <div class="metrics-container">
                    <div class="metric-card">
                        <div class="metric-number">3</div>
                        <div class="metric-label">معدل الغيابات</div>
                    </div>
                    <div class="metric-card good">
                        <div class="metric-number green">13</div>
                        <div class="metric-label">معدل التحفيظ المتبقية</div>
                    </div>
                    <div class="metric-card good">
                        <div class="metric-number blue">18</div>
                        <div class="metric-label">معدل الحصص المتبقية</div>
                    </div>
                    <div class="metric-card">
                        <div style="height: 50px; display: flex; align-items: center; justify-content: center;">
                            <!-- SVG Circle Progress -->
                            <svg width="50" height="50" viewBox="0 0 50 50">
                                <circle cx="25" cy="25" r="20" fill="none" stroke="#eaeaea" stroke-width="5"></circle>
                                <circle cx="25" cy="25" r="20" fill="none" stroke="#27ae60" stroke-width="5" stroke-dasharray="125.6" stroke-dashoffset="31.4" transform="rotate(-90 25 25)"></circle>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid with swapped positions -->
                <div class="main-grid">
                    <!-- Hadith Section (now on the left) -->
                    <div class="hadith-section">
                        <div class="hadith-container">
                            <img src="../img/study.png" alt="Study Illustration" class="illustration" />
                            <div class="hadith-title">قال رسول الله ﷺ</div>
                            <div class="hadith-text">"إذا مات ابن آدم انقطع عمله إلا من ثلاث: صدقة جارية، أو علم ينتفع به، أو ولد صالح يدعو له."</div>
                            <div class="hadith-source"><span>(رواه مسلم)</span></div>
                        </div>
                    </div>

                    <!-- Weekly Menu Section (now on the right) -->
                    <div class="weekly-menu">
                        <div class="section-title">الواجبات (متوفر على مدار الساعة)</div>
                        <div style="text-align: center; font-weight: bold; margin: 10px 0;">الحصة الأسبوعية</div>
                        <table class="menu-table">
                            <tr>
                                <th>اليوم</th>
                                <th>الواجب</th>
                            </tr>
                            <tr>
                                <td>الأحد</td>
                                <td>بيضة + خبز او كسرة </td>
                            </tr>
                            <tr>
                                <td>الإثنين</td>
                                <td>تمر + جزء او كسرة</td>
                            </tr>
                            <tr>
                                <td>الثلاثاء</td>
                                <td>جبن + خبز او كسرة</td>
                            </tr>
                            <tr>
                                <td>الأربعاء</td>
                                <td>فاكهة + او كسرة</td>
                            </tr>
                            <tr>
                                <td>الخميس</td>
                                <td>لجمة حرة</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>