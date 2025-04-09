<?php

require_once __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Student.php';


$studentId = $_SESSION['studen_id']['id'];
$db = DBConnection::getConnection()->getDb();

$groupId = Student::getGroupId(
    $studentId,
    $db
);



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




?>

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
            <div class="time-slot"><?= $schedule[0]['start_time']."_".$schedule[0]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[0]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[7]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[14]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[21]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[28]['subject_name'] ?></div>

            <!-- 8:15-9:00 Row -->
            <div class="time-slot"><?= $schedule[1]['start_time']."_".$schedule[1]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[1]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[8]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[15]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[22]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[29]['subject_name'] ?></div>

            <!-- 9:00-9:30 Row -->
            <div class="time-slot"><?= $schedule[2]['start_time']."_".$schedule[2]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[2]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[9]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[16]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[23]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[30]['subject_name'] ?></div>

            <!-- 9:30-9:40 Row -->
            <div class="time-slot"><?= $schedule[3]['start_time']."_".$schedule[3]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[3]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[10]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[17]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[24]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[31]['subject_name'] ?></div>

            <!-- 9:40-10:30 Row -->
            <div class="time-slot"><?= $schedule[4]['start_time']."_".$schedule[4]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[4]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[11]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[18]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[25]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[32]['subject_name'] ?></div>

            <!-- 10:30-11:00 Row -->
            <div class="time-slot"><?= $schedule[5]['start_time']."_".$schedule[5]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[5]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[12]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[19]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[26]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[33]['subject_name'] ?></div>

            <!-- 11:00-11:30 Row -->
            <div class="time-slot"><?= $schedule[6]['start_time']."_".$schedule[6]['end_time'] ?></div>
            <div class="time-slot"><?= $schedule[6]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[13]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[20]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[27]['subject_name'] ?></div>
            <div class="time-slot"><?= $schedule[34]['subject_name'] ?></div>

            <!-- 11:30-12:00 Row -->

        </div>
    </div>
</div>
</body>

</html>