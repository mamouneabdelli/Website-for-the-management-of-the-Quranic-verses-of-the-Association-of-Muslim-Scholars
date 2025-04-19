<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/Attendance.php';
require_once __DIR__ . '/../../classes/DBConnection.php';

$teacherId = 2;
$db = DBConnection::getConnection()->getDb();
$groupNames = Teacher::getGroups(
    $teacherId,
    $db
);



$attendances = [];

foreach($groupNames as $groupName) {
    $a = new Attendance(
        $groupName['id'],
        $db
    );

    array_push($attendances,$a->getAttendance());
}



?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الحضور والغياب</title>
    <link rel="stylesheet" href="css/attendance.css">    
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
            <img src="../../img/شعار.png" alt="جمعية العلماء المسلمين">
            <p>جمعية العلماء المسلمين الجزائريين</p>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="index.php">لوحة التحكم</a>
            </li>
            <li style="background-color:#B0E4C4;">
                <a href="attendance.php">الحضور والغياب</a>
            </li>
            <li>
                <a href="save.php">الحفظ والمراجعة</a>
            </li>
            <li>
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
            <button class="action-button">تسجيل الحضور</button>
        </div>

        <div class="date-filter">
            <div>
                <label for="date-from">من تاريخ:</label>
                <input type="date" id="date-from" class="date-picker">
            </div>
            <div>
                <label for="date-to">إلى تاريخ:</label>
                <input type="date" id="date-to" class="date-picker">
            </div>
            <button class="filter-btn">
                <i class="fas fa-filter"></i> تصفية
            </button>
        </div>

        <?php foreach($attendances as $groupAttendances) { ?>
        <div class="attendance-session">
            <div class="session-header">
                <div class="session-title"><?= $groupAttendances[0]['group_name'] ?></div>
                <div class="session-date"><?= $groupAttendances[0]['date'] ?></div>
            </div>

            <table class="attendance-table">
                <thead>
                <tr>
                    <th>الطالب</th>
                    <th>رقم الهاتف</th>
                    <th>المستوى</th>
                    <th>الحالة</th>
                    <th>ملاحظات</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($groupAttendances as $attendance) {
                    $bgColor = match ($attendance['status']) {
                        'حاضر' => '#d4edda',
                        'غائب' => '#f8d7da',
                        'متأخر' => '#fff3cd',
                        default => '#e2e3e5',
                    };
                    ?>
                    <tr>
                    <td>
                        <div class="student-profile">
                            <div class="student-avatar">أ</div>
                            <div>
                                <div class="student-name"><?= $attendance['first_name'] ." ". $attendance['last_name'] ?></div>
                                <div class="student-id">ID: <?= $attendance['id'] ?></div>
                            </div>
                        </div>
                    </td>
                    <td><?= $attendance['parent_phone'] ?></td>
                    <td>متقدم</td>
                    <td>
                        <div class="status-buttons">
                        <span style="background-color: <?= $bgColor ?>; padding: 4px 8px; border-radius: 4px;">
                                    <?= $attendance['status'] ?>
                                </span>
                        </div>
                    </td>
                    <td>
                        <input type="text" placeholder="إضافة ملاحظة" style="width: 100%; padding: 5px;">
                    </td>
                </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<script>
    // تفعيل أزرار تحديد الحالة
    document.querySelectorAll('.status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // إزالة الحالة النشطة من جميع الأزرار في نفس المجموعة
            const parentBtns = this.parentElement.querySelectorAll('.status-btn');
            parentBtns.forEach(b => b.classList.remove('active'));

            // تفعيل الزر الحالي
            this.classList.add('active');
        });
    });
</script>
</body>
</html>