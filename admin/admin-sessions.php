<?php
ob_start();
$ac_session = "active";
require_once __DIR__ .'/template/header.php';

// Get filter parameters
$teacher_filter = isset($_GET['teacher']) ? $_GET['teacher'] : 'all';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Build the base query
$sql = "
    SELECT g.*, 
           CONCAT(u.first_name, ' ', u.last_name) as teacher_name,
           COUNT(sg.id) as student_count
    FROM groups g
    LEFT JOIN teachers t ON g.teacher_id = t.id
    LEFT JOIN users u ON t.user_id = u.id
    LEFT JOIN student_groups sg ON g.id = sg.group_id AND sg.status = 'active'
";

// Add teacher filter if specified
if ($teacher_filter !== 'all') {
    $sql .= " WHERE g.teacher_id = :teacher_id";
}

$sql .= " GROUP BY g.id";

// Add sorting
switch ($sort_by) {
    case 'oldest':
        $sql .= " ORDER BY g.start_date ASC";
        break;
    case 'name':
        $sql .= " ORDER BY g.group_name ASC";
        break;
    case 'students':
        $sql .= " ORDER BY student_count DESC";
        break;
    default: // newest
        $sql .= " ORDER BY g.start_date DESC";
}

// Prepare and execute the query
$query = $db->prepare($sql);

if ($teacher_filter !== 'all') {
    $query->bindParam(':teacher_id', $teacher_filter, PDO::PARAM_INT);
}

$query->execute();
$groups = $query->fetchAll(PDO::FETCH_ASSOC);

// Get total statistics
$stats_query = $db->prepare("
    SELECT 
        (SELECT COUNT(*) FROM groups) as total_groups,
        (SELECT COUNT(*) FROM student_groups WHERE status = 'active') as total_students,
        (SELECT COUNT(*) FROM teachers) as total_teachers
");
$stats_query->execute();
$stats = $stats_query->fetch(PDO::FETCH_ASSOC);

// Get all teachers for filter dropdown
$teachers_query = $db->prepare("
    SELECT t.id, CONCAT(u.first_name, ' ', u.last_name) as teacher_name
    FROM teachers t
    JOIN users u ON t.user_id = u.id
");
$teachers_query->execute();
$teachers = $teachers_query->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for adding new group
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_group'])) {
    try {
        $db->beginTransaction();
        
        // Insert into groups table
        $insert_group = $db->prepare("
            INSERT INTO groups (group_name, capacity, academic_year, start_date, teacher_id, description)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        $insert_group->execute([
            $_POST['group_name'],
            $_POST['capacity'],
            $_POST['academic_year'],
            $_POST['start_date'],
            $_POST['teacher_id'],
            $_POST['description']
        ]);
        
        $group_id = $db->lastInsertId();
        
        // Insert curriculum entries for selected days
        /*if (isset($_POST['days']) && is_array($_POST['days'])) {
            $insert_curriculum = $db->prepare("
                INSERT INTO curriculum (day, start_time, end_time, class, teacher_id, subject_id, group_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($_POST['days'] as $day) {
                $insert_curriculum->execute([
                    $day,
                    $_POST['start_time'],
                    $_POST['end_time'],
                    $_POST['class'],
                    $_POST['teacher_id'],
                    $_POST['subject_id'],
                    $group_id
                ]);
            }
        }*/
        
        $db->commit();
        $_SESSION['success'] = "تم إضافة الحلقة بنجاح";
        header("Location: admin-sessions.php");
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        $_SESSION['error'] = "حدث خطأ أثناء إضافة الحلقة: " . $e->getMessage();
    }
}

// Get all subjects for dropdown
$subjects_query = $db->prepare("SELECT * FROM subjects");
$subjects_query->execute();
$subjects = $subjects_query->fetchAll(PDO::FETCH_ASSOC);


$stmt = $db->prepare("SELECT * FROM students");
$stmt->execute();
$student = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="CSS/admin-sessions.css">

<div class="content">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="search-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="بحث عن حلقة...">
        </div>
        <button class="add-btn" id="openAddSessionModal">
            <i class="fas fa-plus"></i> إضافة حلقة جديدة
        </button>
    </div>

    <div class="stats-cards">
        <div class="stat-card">
            <div class="number blue"><?php echo $stats['total_groups']; ?></div>
            <div class="label">إجمالي الحلقات</div>
        </div>
        <div class="stat-card">
            <div class="number green"><?php echo count($student); ?></div>
            <div class="label">إجمالي الطلاب في الحلقات</div>
        </div>
        <div class="stat-card">
            <div class="number red"><?php echo $stats['total_teachers']; ?></div>
            <div class="label">الأساتذة المشرفين</div>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-title">تصفية النتائج</div>
        <form method="GET" action="" class="filter-form">
            <div class="filter-options">
                <div class="filter-option">
                    <label>الأستاذ المشرف:</label>
                    <select name="teacher" class="filter-select" onchange="this.form.submit()">
                        <option value="all">الكل</option>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?php echo $teacher['id']; ?>" 
                                    <?php echo $teacher_filter == $teacher['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($teacher['teacher_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-option">
                    <label>الترتيب:</label>
                    <select name="sort" class="filter-select" onchange="this.form.submit()">
                        <option value="newest" <?php echo $sort_by == 'newest' ? 'selected' : ''; ?>>الأحدث</option>
                        <option value="oldest" <?php echo $sort_by == 'oldest' ? 'selected' : ''; ?>>الأقدم</option>
                        <option value="name" <?php echo $sort_by == 'name' ? 'selected' : ''; ?>>الاسم (أ-ي)</option>
                        <option value="students" <?php echo $sort_by == 'students' ? 'selected' : ''; ?>>عدد الطلاب</option>
                    </select>
                </div>
            </div>
        </form>
    </div>

    <div class="admin-section">
        <div class="section-title">
            قائمة الحلقات
            <span>إجمالي: <?php echo count($groups); ?> حلقة</span>
        </div>

        <div class="tabs">
            <div class="tab active">جميع الحلقات</div>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>اسم الحلقة</th>
                    <th>الأستاذ المشرف</th>
                    <th>عدد الطلاب</th>
                    <th>السنة الدراسية</th>
                    <th>أيام الدراسة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): 
                    
                    $query = $db->prepare("SELECT * FROM student_groups WHERE group_id=?");
                    $query->execute([$group['id']]);
                    $students = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($group['group_name']); ?></td>
                        <td><?php echo htmlspecialchars($group['teacher_name']); ?></td>
                        <td><?php echo count($students); ?> طالب</td>
                        <td><?php echo htmlspecialchars($group['academic_year']); ?></td>
                        <td>
                            <?php
                            $curriculum_query = $db->prepare("SELECT day FROM curriculum WHERE group_id = ?");
                            $curriculum_query->execute([$group['id']]);
                            $days = $curriculum_query->fetchAll(PDO::FETCH_COLUMN);
                            echo implode(' - ', $days);
                            ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-button view" onclick="viewGroup(<?php echo $group['id']; ?>)">
                                    <i class="fas fa-eye"></i> عرض
                                </button>
                                <button class="action-button" onclick="editGroup(<?php echo $group['id']; ?>)">
                                    <i class="fas fa-edit"></i> تعديل
                                </button>
                                <button class="action-button delete" onclick="deleteGroup(<?php echo $group['id']; ?>)">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="admin-section">
        <div class="section-title">
            تفاصيل الحلقة
            <span>حلقة القرآن 1</span>
        </div>

        <div class="session-details">
            <div class="detail-card">
                <h3>معلومات الحلقة</h3>
                <div class="detail-info">
                    <div class="detail-item">
                        <span class="detail-label">اسم الحلقة:</span>
                        <span class="detail-value">حلقة القرآن 1</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">نوع الحلقة:</span>
                        <span class="detail-value">حفظ وتجويد</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المستوى:</span>
                        <span class="detail-value">مبتدئ</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تاريخ البدء:</span>
                        <span class="detail-value">15 فبراير 2025</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">القاعة:</span>
                        <span class="detail-value">قاعة 3 - الطابق الأول</span>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <h3>إحصائيات الحلقة</h3>
                <div class="detail-info">
                    <div class="detail-item">
                        <span class="detail-label">عدد الطلاب:</span>
                        <span class="detail-value">45 طالب</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">متوسط الحضور:</span>
                        <span class="detail-value">89%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">عدد الحصص المنعقدة:</span>
                        <span class="detail-value">35 حصة</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">معدل الإنجاز:</span>
                        <span class="detail-value">72%</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">عدد الحفظة:</span>
                        <span class="detail-value">15 طالب</span>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <h3>معلومات الأستاذ المشرف</h3>
                <div class="detail-info">
                    <div class="detail-item">
                        <span class="detail-label">الاسم:</span>
                        <span class="detail-value">أ. محمد عبد الرحمن</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">التخصص:</span>
                        <span class="detail-value">علوم القرآن والتفسير</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المؤهل العلمي:</span>
                        <span class="detail-value">ماجستير علوم إسلامية</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">رقم الهاتف:</span>
                        <span class="detail-value">0551234567</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">البريد الإلكتروني:</span>
                        <span class="detail-value">mohammed@example.com</span>
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <h3>المحتوى التعليمي</h3>
                <div class="detail-info">
                    <div class="detail-item">
                        <span class="detail-label">المنهج:</span>
                        <span class="detail-value">منهج الجمعية لتعليم القرآن</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المقرر الحالي:</span>
                        <span class="detail-value">سورة البقرة (الجزء الأول)</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">المراجع:</span>
                        <span class="detail-value">مذكرة التجويد الميسر، كتاب أحكام التلاوة</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">الاختبارات:</span>
                        <span class="detail-value">3 اختبارات منجزة من أصل 5</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">تقدم المنهج:</span>
                        <span class="detail-value">65%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="session-schedule">
            <h3 style="margin-bottom: 15px;">جدول الحلقة الأسبوعي</h3>
            
            <div class="schedule-day">
                <div class="day-name">السبت</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-clock"></i>
                        8:00 - 10:00 صباحاً
                    </div>
                </div>
            </div>
            
            <div class="schedule-day">
                <div class="day-name">الأحد</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-times"></i>
                        لا توجد حصص
                    </div>
                </div>
            </div>
            
            <div class="schedule-day">
                <div class="day-name">الإثنين</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-clock"></i>
                        8:00 - 10:00 صباحاً
                    </div>
                </div>
            </div>
            
            <div class="schedule-day">
                <div class="day-name">الثلاثاء</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-times"></i>
                        لا توجد حصص
                    </div>
                </div>
            </div>
            
            <div class="schedule-day">
                <div class="day-name">الأربعاء</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-clock"></i>
                        8:00 - 10:00 صباحاً
                    </div>
                    <div class="time-slot">
                        <i class="fas fa-clock"></i>
                        4:00 - 6:00 مساءً (تسميع)
                    </div>
                </div>
            </div>
            
            <div class="schedule-day">
                <div class="day-name">الخميس</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-times"></i>
                        لا توجد حصص
                    </div>
                </div>
            </div>
            
            <div class="schedule-day">
                <div class="day-name">الجمعة</div>
                <div class="time-slots">
                    <div class="time-slot">
                        <i class="fas fa-times"></i>
                        لا توجد حصص
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Session Modal -->
<div class="modal" id="addSessionModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">إضافة حلقة جديدة</div>
            <button class="close-btn" id="closeAddSessionModal">&times;</button>
        </div>
        <form method="POST" action="">
            <div class="form-group">
                <label class="form-label">اسم الحلقة</label>
                <input type="text" name="group_name" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">الأستاذ المشرف</label>
                <select name="teacher_id" class="form-input" required>
                    <option value="">اختر الأستاذ</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>">
                            <?php echo htmlspecialchars($teacher['teacher_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">السنة الدراسية</label>
                <input type="text" name="academic_year" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">تاريخ البدء</label>
                <input type="date" name="start_date" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-input"></textarea>
            </div>
            <button type="submit" name="add_group" class="form-submit">إضافة الحلقة</button>
        </form>
    </div>
</div>

<style>
.filter-form {
    margin-bottom: 0;
}

.filter-select {
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ddd;
    outline: none;
    min-width: 150px;
}

.filter-select:focus {
    border-color: #00A841;
}
</style>

<script>
// Modal functionality
const openAddSessionModal = document.getElementById('openAddSessionModal');
const closeAddSessionModal = document.getElementById('closeAddSessionModal');
const addSessionModal = document.getElementById('addSessionModal');

openAddSessionModal.addEventListener('click', function() {
    addSessionModal.style.display = 'flex';
});

closeAddSessionModal.addEventListener('click', function() {
    addSessionModal.style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target === addSessionModal) {
        addSessionModal.style.display = 'none';
    }
});

// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchText = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.admin-table tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchText) ? '' : 'none';
    });
});

// Group actions
function viewGroup(id) {
    window.location.href = `view-group.php?id=${id}`;
}

function editGroup(id) {
    window.location.href = `edit-group.php?id=${id}`;
}

function deleteGroup(id) {
    if (confirm('هل أنت متأكد من حذف هذه الحلقة؟')) {
        window.location.href = `delete-group.php?id=${id}`;
    }
}
</script>
</body>
</html>

<?php

ob_end_flush();