<?php
session_start();

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

    <!-- Schedule Section Moved Outside the page-layout for full width -->
    <div class="full-width-container">
        <div class="schedule-section">
            <div class="schedule-title">جدول الحصص (مواعيدي على مدار السنة) <span>الشهر: سبتمبر</span></div>

            <div class="schedule-grid">
                <!-- Day Headers -->
                <div class="day-header">التوقيت</div>
                <div class="day-header">الأحد</div>
                <div class="day-header">الإثنين</div>
                <div class="day-header">الثلاثاء</div>
                <div class="day-header">الأربعاء</div>
                <div class="day-header">الخميس</div>

                <!-- 8:00-8:15 Row -->
                <div class="time-slot">8:00_8:15</div>
                <div class="time-slot">8:00_8:15</div>
                <div class="time-slot"></div>
                <div class="time-slot">8:00_8:15</div>
                <div class="time-slot">8:00_8:15</div>
                <div class="time-slot">8:00_8:15</div>

                <!-- 8:15-9:00 Row -->
                <div class="time-slot">8:15_9:00</div>
                <div class="time-slot">8:15_9:00</div>
                <div class="activity-slot">تدريب الطفل</div>
                <div class="time-slot">8:15_9:00</div>
                <div class="time-slot">8:15_9:00</div>
                <div class="time-slot">8:15_9:00</div>

                <!-- 9:00-9:30 Row -->
                <div class="time-slot">9:30_9:00</div>
                <div class="time-slot">9:30_9:00</div>
                <div class="activity-slot">استقبال البراعم</div>
                <div class="time-slot">9:30_9:00</div>
                <div class="time-slot">9:30_9:00</div>
                <div class="time-slot">9:30_9:00</div>

                <!-- 9:30-9:40 Row -->
                <div class="time-slot">9:40_9:30</div>
                <div class="time-slot">9:40_9:30</div>
                <div class="activity-slot">الاستعادة و السلمة</div>
                <div class="time-slot">9:40_9:30</div>
                <div class="time-slot">9:40_9:30</div>
                <div class="time-slot">9:40_9:30</div>

                <!-- 9:40-10:30 Row -->
                <div class="time-slot">10:30_9:40</div>
                <div class="time-slot">10:30_9:40</div>
                <div class="time-slot">10:30_9:40</div>
                <div class="time-slot">10:30_9:40</div>
                <div class="time-slot">10:30_9:40</div>
                <div class="time-slot">10:30_9:40</div>

                <!-- 10:30-11:00 Row -->
                <div class="time-slot">11:00_10:30</div>
                <div class="time-slot">11:00_10:30</div>
                <div class="time-slot">11:00_10:30</div>
                <div class="time-slot">11:00_10:30</div>
                <div class="activity-slot">تدريب الطفل</div>
                <div class="time-slot">11:00_10:30</div>

                <!-- 11:00-11:30 Row -->
                <div class="time-slot">11:00_11:30</div>
                <div class="time-slot">11:00_11:30</div>
                <div class="time-slot">11:00_11:30</div>
                <div class="time-slot">11:00_11:30</div>
                <div class="activity-slot">الاستعادة و السلامة</div>
                <div class="time-slot">11:00_11:30</div>

                <!-- 11:30-12:00 Row -->
                <div class="time-slot">12:00_11:00</div>
                <div class="time-slot">12:00_11:00</div>
                <div class="time-slot">12:00_11:00</div>
                <div class="time-slot">12:00_11:00</div>
                <div class="time-slot">12:00_11:00</div>
                <div class="time-slot">12:00_11:00</div>
            </div>
        </div>
    </div>

    <script>
        // Sample data for metrics 
        const metricsData = {
            absences: 3,
            remainingMemorization: 13,
            remainingClasses: 18,
            progress: 75 // Percentage
        };

        // Update metrics with actual data 
        function updateMetrics(data) {
            document.querySelectorAll('.metric-number')[0].textContent = data.absences;
            document.querySelectorAll('.metric-number')[1].textContent = data.remainingMemorization;
            document.querySelectorAll('.metric-number')[2].textContent = data.remainingClasses;

            // Update circle progress 
            const circle = document.querySelector('circle:nth-child(2)');
            const radius = 20;
            const circumference = 2 * Math.PI * radius;
            const offset = circumference - (data.progress / 100) * circumference;
            circle.style.strokeDasharray = circumference;
            circle.style.strokeDashoffset = offset;
        }

        // Call update function with sample data 
        updateMetrics(metricsData);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const gradesButton = document.querySelector('.sidebar-btn:nth-child(3)');
            const notificationsButton = document.querySelector('.sidebar-btn:nth-child(4)');


            const scheduleSection = document.querySelector('.schedule-section');
            const mainGrid = document.querySelector('.main-grid');


            const notificationsSection = document.createElement('div');
            notificationsSection.className = 'schedule-section';
            notificationsSection.innerHTML = `
        <div class="schedule-title">الاشعارات <span>الرسائل الجديدة</span></div>
        <div style="padding: 10px;">
            <div style="background-color: #f8f8f8; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-right: 4px solid #27ae60;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="color: #777; font-size: 12px;">اليوم 10:30</span>
                    <strong>إدارة جمعية العلماء المسلمين</strong>
                </div>
                <p>نعلم الطلبة الأعزاء بتعديل جدول الحصص ليوم الخميس هذا الأسبوع...</p>
            </div>
            
            <div style="background-color: #f8f8f8; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-right: 4px solid #27ae60;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="color: #777; font-size: 12px;">البارحة 14:15</span>
                    <strong>إدارة جمعية العلماء المسلمين</strong>
                </div>
                <p>نعلم الطلبة الأعزاء بتعديل جدول الحصص ليوم الخميس هذا الأسبوع...</p>
            </div>
            
            <div style="background-color: #f8f8f8; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-right: 4px solid #27ae60;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="color: #777; font-size: 12px;">21/03/2025 09:45</span>
                    <strong>إدارة جمعية العلماء المسلمين</strong>
                </div>
                <p>نعلم الطلبة الأعزاء بتعديل جدول الحصص ليوم الخميس هذا الأسبوع...</p>
            </div>
            
            <div style="background-color: #f8f8f8; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-right: 4px solid #27ae60;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                    <span style="color: #777; font-size: 12px;">18/03/2025 16:20</span>
                    <strong>إدارة جمعية العلماء المسلمين</strong>
                </div>
                <p>نعلم الطلبة الأعزاء بتعديل جدول الحصص ليوم الخميس هذا الأسبوع...</p>
            </div>
        </div>
    `;


            const gradesSection = document.createElement('div');
            gradesSection.className = 'schedule-section';
            gradesSection.innerHTML = `
        <div class="schedule-title">علامات الاختبارات <span>النتائج الحالية</span></div>
        <div style="padding: 10px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">المادة</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">العلامة</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">التاريخ</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">القرآن الكريم - الجزء الأول</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee; font-weight: bold; color: #27ae60;">85/100</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">15/03/2025</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                            <span style="background-color: #d4e9d7; padding: 4px 8px; border-radius: 4px;">ناجح</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">التجويد</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee; font-weight: bold; color: #27ae60;">78/100</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">10/03/2025</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                            <span style="background-color: #d4e9d7; padding: 4px 8px; border-radius: 4px;">ناجح</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">الأحاديث النبوية</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee; font-weight: bold; color: #d35400;">65/100</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">05/03/2025</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                            <span style="background-color: #f5dcc5; padding: 4px 8px; border-radius: 4px;">مقبول</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">السيرة النبوية</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee; font-weight: bold; color: #27ae60;">92/100</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">28/02/2025</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                            <span style="background-color: #d4e9d7; padding: 4px 8px; border-radius: 4px;">ممتاز</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;


            document.querySelector('.full-width-container').appendChild(notificationsSection);
            notificationsSection.style.display = 'none';


            document.querySelector('.full-width-container').appendChild(gradesSection);
            gradesSection.style.display = 'none';


            gradesButton.addEventListener('click', function() {

                scheduleSection.style.display = 'none';
                notificationsSection.style.display = 'none';
                mainGrid.style.display = 'none';

                gradesSection.style.display = 'block';


                gradesButton.style.backgroundColor = '#8BC34A';
                notificationsButton.style.backgroundColor = '#B0E4C4';
            });

            notificationsButton.addEventListener('click', function() {

                scheduleSection.style.display = 'none';
                gradesSection.style.display = 'none';
                mainGrid.style.display = 'none';


                notificationsSection.style.display = 'block';

                notificationsButton.style.backgroundColor = '#8BC34A';
                gradesButton.style.backgroundColor = '#B0E4C4';
            });


            const dashboardButton = document.querySelector('.sidebar-btn:nth-child(1)');
            dashboardButton.addEventListener('click', function() {

                scheduleSection.style.display = 'block';
                mainGrid.style.display = 'grid';


                notificationsSection.style.display = 'none';
                gradesSection.style.display = 'none';


                notificationsButton.style.backgroundColor = '#B0E4C4';
                gradesButton.style.backgroundColor = '#B0E4C4';
                dashboardButton.style.backgroundColor = '#8BC34A';
            });


            dashboardButton.style.backgroundColor = '#8BC34A';
        });
    </script>

</body>

</html>