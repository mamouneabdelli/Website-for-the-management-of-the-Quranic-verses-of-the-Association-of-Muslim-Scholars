<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/Attendance.php';
require_once __DIR__ . '/../../classes/DBConnection.php';



if (isset($_SESSION['teacher_id'])) {
    $teacherId = $_SESSION['teacher_id'];
} else {
    // إذا لم يتم تسجيل الدخول، يتم إعادة التوجيه إلى صفحة تسجيل الدخول
    header("Location: /quranic/login.php");
    exit();
}
$db = DBConnection::getConnection()->getDb();
$groupNames = Teacher::getGroups(
    $teacherId,
    $db
);


$date1 = $_POST['date_1'] ?? null;
$date2 = $_POST['date_2'] ?? null;


if ($date1 && $date2) {
    
    if ($date1 > $date2) {
        [$date1, $date2] = [$date2, $date1]; 
    }
}


    $attendancesByGroupAndDate = [];

    foreach ($groupNames as $groupName) {
        $groupN = $groupName['group_name'];
        $a = new Attendance($groupName['id'], $db);
        $groupAttendance = $a->getAttendance();
        foreach ($groupAttendance as $attendance) {
            $date = $attendance['date'];

            if ($date1 && $date2 && ($date < $date1 || $date > $date2)) {
                continue; 
            }

            if (!isset($attendancesByGroupAndDate[$groupN])) {
                $attendancesByGroupAndDate[$groupN] = [];
            }

            if (!isset($attendancesByGroupAndDate[$groupN][$date])) {
                $attendancesByGroupAndDate[$groupN][$date] = [];
            }

            $attendancesByGroupAndDate[$groupN][$date][] = $attendance;
        }
    }

/*echo "<pre>";
print_r($attendancesByGroupAndDate);
echo "</pre>";*/

?>

<link rel="stylesheet" href="css/attendance.css">

<div class="content">
    <div class="search-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="بحث عن الطالب">
        </div>
        <a class="action-button" href="record_attendance.php">تسجيل الحضور</a>
    </div>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="date-filter">
        <div>
            <label for="date-from">من تاريخ:</label>
            <input type="date" id="date-from" class="date-picker" name="date_1" value="<?= htmlspecialchars($date1) ?>">
        </div>
        <div>
            <label for="date-to">إلى تاريخ:</label>
            <input type="date" id="date-to" class="date-picker" name="date_2" value="<?= htmlspecialchars($date2) ?>">
        </div>

        <button class="filter-btn" type="submit">
            <i class="fas fa-filter"></i> تصفية
        </button>
    </form>

    <?php foreach ($attendancesByGroupAndDate as $groupName => $attendancesByGroup) { ?>
        <div class="attendance-session">
            <div class="session-header">
                <div class="session-title"><?= $groupName ?? "اسم المجموعة" ?></div>
            </div>

            <?php foreach ($attendancesByGroup as $groupDate => $attendancesByDate) { ?>
                <div class="session-date"><?= $groupDate ?? "التاريخ" ?>  </div>

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
                        foreach ($attendancesByDate as $attendance) {
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
                                            <div class="student-name"><?= $attendance['first_name'] . " " . $attendance['last_name'] ?></div>
                                            <div class="student-id">ID: <?= $attendance['id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= $attendance['phone'] ?></td>
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
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    <?php } ?>

</div>
</div>

</body>

</html>