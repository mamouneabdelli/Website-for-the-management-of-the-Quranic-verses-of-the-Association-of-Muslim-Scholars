<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/DBConnection.php';


$groupNames = [];

if (isset($_SESSION['teacher_id'])) {


}

$teacherId = 2;
$db = DBConnection::getConnection()->getDb();
$schedule = null;
$groupNames = Teacher::getGroups(
    $teacherId,
    $db
);

if (isset($_GET['id']))
    $groupId = $_GET['id'];

if (!empty($groupId)) {

    $query = $db->prepare("SELECT 
        schedule.id,
        days.name AS day_name,
        TIME_FORMAT(periods.start_time, '%H:%i') AS start_time,
        TIME_FORMAT(periods.end_time, '%H:%i') AS end_time,
        subjects.name AS subject_name
    FROM schedule
    JOIN days ON schedule.day_id = days.id
    JOIN periods ON schedule.period_id = periods.id
    JOIN subjects ON schedule.subject_id = subjects.id
        WHERE schedule.group_id = {$groupId[0]['group_id']}
        ORDER BY schedule.id ASC
    
    ");

    $query->execute();
    $schedule = $query->fetchAll(PDO::FETCH_ASSOC);
}

$studentGroup = [];
if (isset($groupId)) {
    $query = $db->prepare("SELECT * FROM student_group WHERE group_id=? ");
    $query->execute([$groupId]);
    $studentGroup = $query->fetchAll(PDO::FETCH_ASSOC);
}

$totalStudent = [];

if (isset($groupNames)) {
    foreach ($groupNames as $groupName) {
        $query = $db->prepare("SELECT * FROM student_groups WHERE group_id=? ");
        $query->execute([$groupName['id']]);
        $totalStudent = $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>




<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الأستاذ</title>
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

        /* Main Content Styles */
        .content {
            flex: 1;
            padding: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-input {
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
            border-radius: 20px;
            padding: 8px 15px;
            width: 300px;
        }

        .search-input input {
            border: none;
            background: transparent;
            width: 100%;
            padding-right: 10px;
            outline: none;
        }

        .register-student-btn {
            background-color: #00A841;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        /* Stats Cards */
        .stats-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }

        .stat-card .number {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card .label {
            color: #666;
            font-size: 12px;
        }

        .blue { color: #2196F3; }
        .green { color: #00A841; }
        .red { color: #ff5252; }

        /* Session Cards */
        .session-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
            background-color: white;
            padding: 10px;
            border-radius: 10px;
        }

        .session-card {
            border-radius: 8px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .session-card i {
            background-color: white;
            color: #ffffff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .session-card .title {
            color: #ffffff;
            font-size: 14px;
            background: none;
            border: none;
            cursor: pointer;
            text-align: right;
            width: 100%;
            font-weight: 600;
        }

        /* Schedule Section */
        .schedule-section {
            margin-top: 20px;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .schedule-header {
            display: flex;
            margin-bottom: 10px;
        }

        .day-header {
            flex: 1;
            text-align: center;
            background-color: #E6F7E9;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: bold;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .schedule-cell {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 8px;
            text-align: center;
            min-height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .schedule-cell.filled {
            background-color: #E6F7E9;
        }

        .time-slot {
            background-color: #E6F7E9;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .session-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-cards {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-left: none;
                border-bottom: 1px solid #e0e0e0;
            }

            .search-bar {
                flex-direction: column;
                gap: 10px;
            }

            .search-input {
                width: 100%;
            }

            .schedule-header, .schedule-grid {
                grid-template-columns: 1fr;
            }
         }
        .sidebar-menu  a {
            text-decoration: none;
            color: black;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="welcome-msg">
            أهلا بك يا <span>الأستاذ محمد</span>
        </div>
        <div class="header-icons">
            <i class="fas fa-bell"></i>
            <i class="fas fa-envelope"></i>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.png" alt="جمعية العلماء المسلمين">
                <p>جمعية العلماء المسلمين الجزائريين</p>
            </div>
            <ul class="sidebar-menu">
                <li style="background-color:#B0E4C4;">
                    <a href="index.html" >لوحة التحكم</a>
                </li>
                <li>
                    <a href="attendance.php">الحضور والغياب</a>
                </li>
                <li>
                    <a href="save.html">الحفظ والمراجعة</a>
                </li>
                <li >
                    <a href="report.html">إرسال تقرير</a>
                </li>
            </ul>
            <div class="register-btn">
                <i class="fas fa-arrow-left"></i> تسجيل الدخول
            </div>
        </div>
        
        <div class="content">
            <div class="search-bar">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث عن الطالب">
                </div>
                <button class="register-student-btn">تسجيل أسماء و بيانات الطلاب</button>
            </div>
            
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="number red"><?= count($groupNames) ?></div>
                    <div class="label">إجمالي الحلقات التي تشرف عليها</div>
                </div>
                <div class="stat-card">
                    <div class="number green"><?= count($studentGroup) ?></div>
                    <div class="label">عدد الحضور الجلسة</div>
                </div>
                <div class="stat-card">
                    <div class="number blue"><?= count($totalStudent) ?></div>
                    <div class="label">إجمالي عدد الطلاب</div>
                </div>
            </div>
            
            <div class="session-cards">
                <?php
                if (!empty($groupNames)) {
                    foreach ($groupNames as $groupName) {
                ?>
                <div class="session-card" style="background-color:#00A841;">
                    <i class="fas fa-book-open"></i>
                    <a class="title" href="?id=<?= $groupName['id'] ?>"><?= $groupName['group_name'] ?></a>
                </div>
                <?php
                    }
                }else {
                 ?>
                    لا توجد حلقات
                <?php
                }
                ?>
            </div>


            <div class="schedule-section">
                <div class="schedule-header">
                    <div class="day-header">التوقيت</div>
                    <div class="day-header">الأحد</div>
                    <div class="day-header">الثلاثاء</div>
                    <div class="day-header">الخميس</div>
                </div>

                <div class="schedule-grid">
                    <div class="time-slot">8:00 - 8:15</div>
                    <div class="schedule-cell filled">حفظ القرآن</div>
                    <div class="schedule-cell"></div>
                    <div class="schedule-cell filled">حفظ القرآن</div>

                    <div class="time-slot">8:15 - 9:00</div>
                    <div class="schedule-cell"></div>
                    <div class="schedule-cell filled">حفظ القرآن</div>
                    <div class="schedule-cell"></div>

                    <div class="time-slot">9:00 - 9:30</div>
                    <div class="schedule-cell"></div>
                    <div class="schedule-cell filled">الأحكام</div>
                    <div class="schedule-cell filled">حفظ القرآن</div>

                    <div class="time-slot">9:30 - 9:40</div>
                    <div class="schedule-cell filled">مراجعة</div>
                    <div class="schedule-cell"></div>
                    <div class="schedule-cell"></div>

                    <div class="time-slot">9:40 - 10:30</div>
                    <div class="schedule-cell filled">مراجعة</div>
                    <div class="schedule-cell"></div>
                    <div class="schedule-cell filled">مراجعة</div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // يمكن إضافة التفاعلات هنا
        document.querySelectorAll('.session-card').forEach(card => {
            card.addEventListener('click', function() {
                const sessionName = this.querySelector('.title').textContent;
                alert('تم اختيار: ' + sessionName);
            });
        });
    </script>
</body>
</html>