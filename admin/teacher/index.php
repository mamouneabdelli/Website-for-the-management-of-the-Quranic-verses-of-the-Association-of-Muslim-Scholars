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
        WHERE schedule.group_id = {$groupId}
        ORDER BY schedule.id ASC
    
    ");

    $query->execute();
    $schedule = $query->fetchAll(PDO::FETCH_ASSOC);
}

$studentGroup = [];
if (isset($groupId)) {
    $query = $db->prepare("SELECT * FROM student_groups WHERE group_id=? ");
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


<link rel="stylesheet" href="css/style.css">


        
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