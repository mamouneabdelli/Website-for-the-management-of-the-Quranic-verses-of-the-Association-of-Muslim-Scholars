<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/DBConnection.php';

$groupNames = [];

if (isset($_SESSION['teacher_id'])) {
    // Suggest using $_SESSION['teacher_id'] for production
}

$teacherId = 2;
$db = DBConnection::getConnection()->getDb();
$groupNames = Teacher::getGroups($teacherId, $db);

$schedule = null;
$groupId = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT) : null;

// Fetch selected group name for title
$selectedGroupName = '';
if (!empty($groupId)) {
    foreach ($groupNames as $group) {
        if ($group['id'] == $groupId) {
            $selectedGroupName = $group['group_name'];
            break;
        }
    }
}

if (!empty($groupId)) {
    
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
    $query->execute([$groupId]);
    $schedule = $query->fetchAll(PDO::FETCH_ASSOC);
}

$studentGroup = [];
if (!empty($groupId)) {
    $query = $db->prepare("SELECT * FROM student_groups WHERE group_id = ?");
    $query->execute([$groupId]);
    $studentGroup = $query->fetchAll(PDO::FETCH_ASSOC);
}

$totalStudent = [];
if (!empty($groupNames)) {
    foreach ($groupNames as $groupName) {
        $query = $db->prepare("SELECT * FROM student_groups WHERE group_id = ?");
        $query->execute([$groupName['id']]);
        $totalStudent = array_merge($totalStudent, $query->fetchAll(PDO::FETCH_ASSOC));
    }
}
?>

<link rel="stylesheet" href="css/style.css">

<style>
    .schedule-section {
        margin-top: 20px;
        direction: rtl;
    }

    .section-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .section-title span {
        font-size: 18px;
        color: #555;
        margin-right: 10px;
    }

    .search-bar {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #dee2e6;
    }

    .search-bar i {
        margin-left: 10px;
        color: #666;
    }

    .search-bar input {
        flex: 1;
        border: none;
        background: transparent;
        outline: none;
        font-size: 16px;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .schedule-table th,
    .schedule-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #dee2e6;
    }

    .schedule-table th {
        background-color: #f8f9fa;
        font-weight: bold;
        color: #333;
    }

    .schedule-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .no-schedule {
        text-align: center;
        padding: 20px;
        color: #721c24;
        font-weight: bold;
    }
</style>

<div class="content">
    

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
        <?php if (!empty($groupNames)): ?>
            <?php foreach ($groupNames as $groupName): ?>
                <div class="session-card" style="background-color: <?= $groupId == $groupName['id'] ? '#00802b' : '#00A841' ?>;">
                    <i class="fas fa-book-open"></i>
                    <a class="title" href="?id=<?= htmlspecialchars($groupName['id']) ?>"><?= htmlspecialchars($groupName['group_name']) ?></a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>لا توجد حلقات</p>
        <?php endif; ?>
    </div>

    <div class="schedule-section">
        <div class="section-title">
            البرنامج الأسبوعي
            <?php if (!empty($selectedGroupName)): ?>
                <span><?= htmlspecialchars($selectedGroupName) ?></span>
            <?php endif; ?>
        </div>
        <?php if (!empty($groupId) && !empty($schedule)): ?>
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
                    <?php foreach ($schedule as $entry): ?>
                        <tr>
                            <td><?= htmlspecialchars($entry['day']) ?></td>
                            <td>
                                <?php
                                // Convert to 12-hour format with AM/PM for consistency
                                $startTime = date('h:i A', strtotime($entry['start_time']));
                                $endTime = date('h:i A', strtotime($entry['end_time']));
                                echo $startTime . ' - ' . $endTime;
                                ?>
                            </td>
                            <td><?= htmlspecialchars($entry['name']) ?></td>
                            <td><?= htmlspecialchars($entry['first_name']) ?></td>
                            <td><?= htmlspecialchars($entry['class']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-schedule">يرجى اختيار حلقة لعرض الجدول</p>
        <?php endif; ?>
    </div>
</div>

<script>
    // Highlight selected session card and handle search
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.querySelector('.schedule-section .search-bar input');
        const tableRows = document.querySelectorAll('.schedule-table tbody tr');

        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.trim().toLowerCase();
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = searchTerm === '' || text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
</body>

</html>