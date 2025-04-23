<?php

require_once __DIR__ . '/template/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Progress.php';
require_once __DIR__ . '/../../classes/Student.php';
require_once __DIR__ . '/../../classes/Teacher.php';




$studentId = $_SESSION['student_id']['id'];

$db = DBConnection::getConnection()->getDb();


$groupId = Student::getGroupId($studentId, $db);

$progresses = Student::getProggresses($studentId, $db);

$messages = Teacher::getMessages($groupId[0]['group_id'], $db);

try {
    $query = $db->prepare("
SELECT 
subjects.name,
groups.group_name,
users.first_name,
users.last_name,
curriculum.day,
curriculum.start_time,
curriculum.end_time,
curriculum.class
FROM curriculum
JOIN subjects ON curriculum.subject_id = subjects.id
JOIN teachers ON curriculum.teacher_id = teachers.id
JOIN users ON teachers.user_id = users.id
JOIN groups ON curriculum.group_id = groups.id
WHERE curriculum.group_id = ?
ORDER BY curriculum.id ASC;

");
    $query->execute([$groupId[0]['group_id']]);
    $schedules = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}

?>

<link rel="stylesheet" href="css/schedule.css">

        <div class="content">
            <div class="schedule-section">
                <div class="section-title">
                    البرنامج الأسبوعي
                    <span>حلقة القرآن رقم 1</span>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في البرنامج...">
                </div>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>اليوم</th>
                            <th>الوقت</th>
                            <th>المادة</th>
                            <th>الأستاذ</th>
                            <th>الموقع</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($schedules as $schedule) { ?>
                <tr>
                    <td><?= $schedule['day'] ?></td>
                    <td><?= date("H:i",strtotime($schedule['start_time'])). " - " . date("H:i",strtotime($schedule['end_time'])) ?></td>
                    <td><?= $schedule['name'] ?></td>
                    <td><?= $schedule['first_name']. " " . $schedule['last_name'] ?></td>
                    <td><?= $schedule['class'] ?></td>
                </tr>
                <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.search-bar input').addEventListener('input', () => {
            alert('البحث قيد التطوير! يرجى إضافة منطق البحث لاحقًا.');
        });
    </script>
</body>
</html>