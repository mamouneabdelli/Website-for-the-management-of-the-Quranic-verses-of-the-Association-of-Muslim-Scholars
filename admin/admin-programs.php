<?php
$ac_programs = "active";
require_once __DIR__ .'/template/header.php';

$db = DBConnection::getConnection()->getDb();

// Get total weekly sessions count
$totalSessionsQuery = "SELECT COUNT(*) as total FROM curriculum";
$totalSessions = $db->query($totalSessionsQuery)->fetch(PDO::FETCH_ASSOC)['total'];

// Get active groups count
$activeGroupsQuery = "SELECT COUNT(*) as total FROM groups WHERE end_date IS NULL OR end_date > CURDATE()";
$activeGroups = $db->query($activeGroupsQuery)->fetch(PDO::FETCH_ASSOC)['total'];

// Get all teachers for filter
$teachersQuery = "SELECT t.id, CONCAT(u.first_name, ' ', u.last_name) as name 
                 FROM teachers t 
                 JOIN users u ON t.user_id = u.id";
$teachersStmt = $db->query($teachersQuery);
$teachers = $teachersStmt->fetchAll(PDO::FETCH_ASSOC);

// Get all rooms for filter
$roomsQuery = "SELECT DISTINCT class FROM curriculum";
$roomsStmt = $db->query($roomsQuery);
$rooms = $roomsStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<link rel="stylesheet" href="CSS/admin-programs.css">

<div class="content">
    <div class="search-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="بحث في الجدول...">
        </div>
        <button class="add-btn" id="openScheduleModal">
            <i class="fas fa-plus"></i> إضافة موعد جديد
        </button>
    </div>

    <div class="stats-cards">
        <div class="stat-card">
            <div class="number blue"><?php echo $totalSessions; ?></div>
            <div class="label">إجمالي المواعيد الأسبوعية</div>
        </div>
        <div class="stat-card">
            <div class="number green"><?php echo $activeGroups; ?></div>
            <div class="label">الحلقات النشطة</div>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-title">تصفية الجدول</div>
        <div class="filter-options">
            <div class="filter-option">
                <label>نوع الحلقة:</label>
                <select class="filter-select" id="typeFilter">
                    <option value="all">الكل</option>
                    <option value="quran">حلقات القرآن</option>
                    <option value="hadith">حلقات الحديث</option>
                    <option value="fiqh">حلقات الفقه</option>
                    <option value="tafsir">حلقات التفسير</option>
                </select>
            </div>
            <div class="filter-option">
                <label>القاعة:</label>
                <select class="filter-select" id="roomFilter">
                    <option value="all">الكل</option>
                    <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo htmlspecialchars($room); ?>"><?php echo htmlspecialchars($room); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-option">
                <label>الأستاذ:</label>
                <select class="filter-select" id="teacherFilter">
                    <option value="all">الكل</option>
                    <?php foreach ($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['id']; ?>"><?php echo htmlspecialchars($teacher['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="schedule-container">
        <div class="admin-section">
            <div class="section-title">
                الجدول الأسبوعي للحلقات
                <span>الأسبوع الحالي</span>
            </div>

            <div class="schedule-legend">
                <div class="legend-item">
                    <div class="legend-color quran"></div>
                    <span>حلقات القرآن</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color hadith"></div>
                    <span>حلقات الحديث</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color fiqh"></div>
                    <span>حلقات الفقه</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color tafsir"></div>
                    <span>حلقات التفسير</span>
                </div>
            </div>

            <div class="tabs">
                <div class="tab active" data-week="current">الأسبوع الحالي</div>
                <div class="tab" data-week="next">الأسبوع القادم</div>
                <div class="tab" data-week="month">عرض شهري</div>
            </div>

            <div class="weekly-schedule" id="weeklySchedule">
                <!-- Schedule headers -->
                <div class="schedule-header">الوقت</div>
                <div class="schedule-header">السبت</div>
                <div class="schedule-header">الأحد</div>
                <div class="schedule-header">الإثنين</div>
                <div class="schedule-header">الثلاثاء</div>
                <div class="schedule-header">الأربعاء</div>
                <div class="schedule-header">الخميس</div>
                <div class="schedule-header">الجمعة</div>

                <?php
                // Get schedule data
                $scheduleQuery = "SELECT 
                    c.id,
                    c.day,
                    c.start_time,
                    c.end_time,
                    c.class as room,
                    g.group_name as name,
                    s.name as subject_name,
                    CONCAT(u.first_name, ' ', u.last_name) as teacher_name,
                    t.id as teacher_id
                FROM curriculum c
                JOIN groups g ON c.group_id = g.id
                JOIN subjects s ON c.subject_id = s.id
                JOIN teachers t ON c.teacher_id = t.id
                JOIN users u ON t.user_id = u.id
                ORDER BY FIELD(c.day, 'السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'),
                         c.start_time";
                
                $scheduleStmt = $db->query($scheduleQuery);
                $sessions = $scheduleStmt->fetchAll(PDO::FETCH_ASSOC);

                //print_r($sessions);

                // Map subject names to types for CSS classes
                $typeMap = [
                    'القرأن الكريم' => 'quran',
                    'التربية الاسلامية' => 'hadith',
                    'لغة عربية' => 'fiqh',
                    'سيرة نبوية' => 'tafsir'
                ];

                // Time slots
                $timeSlots = ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00'];
                $days = ['السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'];

                // Create schedule grid
                foreach ($timeSlots as $time) {
                    // Add time slot
                    echo '<div class="time-slot">';
                    $hour = (int)substr($time, 0, 2);
                    $ampm = $hour >= 12 ? 'م' : 'ص';
                    $displayHour = $hour % 12 ? $hour % 12 : 12;
                    echo $displayHour . ':' . substr($time, 3, 2) . ' ' . $ampm;
                    echo '</div>';

                    // Add cells for each day
                    foreach ($days as $day) {
                        echo '<div class="schedule-cell">';
                        // Find sessions for this time slot and day

                        foreach ($sessions as $session) {
                        //print_r($session);
                            if ($session['day'] === $day && date("H:i", strtotime($session['start_time'])) === $time) {
                                $type = $typeMap[$session['subject_name']] ?? 'other';
                                echo '<div class="session-block ' . $type . '" data-teacher-id="' . $session['teacher_id'] . '">';
                                echo '<div class="session-name">' . htmlspecialchars($session['name']) . '</div>';
                                echo '<div class="session-teacher">' . htmlspecialchars($session['teacher_name']) . '</div>';
                                echo '<div class="session-room">' . htmlspecialchars($session['room']) . '</div>';
                                echo '</div>';
                            }
                        }
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <!-- قائمة المواعيد المتاحة -->
    <div class="schedule-list-section">
        <div class="section-title">
            المواعيد المتاحة
        </div>
        <div class="schedule-list">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>اليوم</th>
                        <th>وقت البداية</th>
                        <th>وقت النهاية</th>
                        <th>الحلقة</th>
                        <th>المادة</th>
                        <th>الأستاذ</th>
                        <th>القاعة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($sessions as $session) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($session['day']) . '</td>';
                        echo '<td>' . htmlspecialchars($session['start_time']) . '</td>';
                        echo '<td>' . htmlspecialchars($session['end_time']) . '</td>';
                        echo '<td>' . htmlspecialchars($session['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($session['subject_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($session['teacher_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($session['room']) . '</td>';
                        echo '<td class="actions">';
                        echo '<button class="edit-btn" onclick="editSchedule(' . $session['id'] . ')"><i class="fas fa-edit"></i></button>';
                        echo '<button class="delete-btn" onclick="deleteSchedule(' . $session['id'] . ')"><i class="fas fa-trash"></i></button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for Adding New Schedule -->
<div class="modal" id="scheduleModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">إضافة موعد جديد للحلقة</div>
            <button class="close-btn" id="closeScheduleModal">&times;</button>
        </div>
        <form id="scheduleForm">
            <div class="form-group">
                <label class="form-label">الحلقة</label>
                <select class="form-input" id="group_id" required>
                    <?php
                    $groupsQuery = "SELECT g.id, g.group_name, CONCAT(u.first_name, ' ', u.last_name) as teacher_name 
                                  FROM groups g 
                                  JOIN teachers t ON g.teacher_id = t.id 
                                  JOIN users u ON t.user_id = u.id 
                                  WHERE g.end_date IS NULL OR g.end_date > CURDATE()";
                    $groupsStmt = $db->query($groupsQuery);
                    while ($group = $groupsStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$group['id']}'>{$group['group_name']} - {$group['teacher_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">اليوم</label>
                <select class="form-input" id="day" required>
                    <option value="saturday">السبت</option>
                    <option value="sunday">الأحد</option>
                    <option value="monday">الإثنين</option>
                    <option value="tuesday">الثلاثاء</option>
                    <option value="wednesday">الأربعاء</option>
                    <option value="thursday">الخميس</option>
                    <option value="friday">الجمعة</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">وقت البداية</label>
                <input type="time" class="form-input" id="start_time" required>
            </div>
            <div class="form-group">
                <label class="form-label">وقت النهاية</label>
                <input type="time" class="form-input" id="end_time" required>
            </div>
            <div class="form-group">
                <label class="form-label">القاعة</label>
                <input type="text" class="form-input" id="class" placeholder="مثال: قاعة 1" required>
            </div>
            <div class="form-group">
                <label class="form-label">المادة</label>
                <select class="form-input" id="subject_id" required>
                    <?php
                    $subjectsQuery = "SELECT id, name FROM subjects";
                    $subjectsStmt = $db->query($subjectsQuery);
                    while ($subject = $subjectsStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$subject['id']}'>{$subject['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="form-submit">إضافة الموعد</button>
        </form>
    </div>
</div>

<!-- Modal for Editing Schedule -->
<div class="modal" id="editScheduleModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">تعديل الموعد</div>
            <button class="close-btn" id="closeEditModal">&times;</button>
        </div>
        <form id="editScheduleForm">
            <input type="hidden" id="edit_schedule_id">
            <div class="form-group">
                <label class="form-label">الحلقة</label>
                <select class="form-input" id="edit_group_id" required>
                    <?php
                    $groupsQuery = "SELECT g.id, g.group_name, CONCAT(u.first_name, ' ', u.last_name) as teacher_name 
                                  FROM groups g 
                                  JOIN teachers t ON g.teacher_id = t.id 
                                  JOIN users u ON t.user_id = u.id 
                                  WHERE g.end_date IS NULL OR g.end_date > CURDATE()";
                    $groupsStmt = $db->query($groupsQuery);
                    while ($group = $groupsStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$group['id']}'>{$group['group_name']} - {$group['teacher_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">اليوم</label>
                <select class="form-input" id="edit_day" required>
                    <option value="saturday">السبت</option>
                    <option value="sunday">الأحد</option>
                    <option value="monday">الإثنين</option>
                    <option value="tuesday">الثلاثاء</option>
                    <option value="wednesday">الأربعاء</option>
                    <option value="thursday">الخميس</option>
                    <option value="friday">الجمعة</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">وقت البداية</label>
                <input type="time" class="form-input" id="edit_start_time" required>
            </div>
            <div class="form-group">
                <label class="form-label">وقت النهاية</label>
                <input type="time" class="form-input" id="edit_end_time" required>
            </div>
            <div class="form-group">
                <label class="form-label">القاعة</label>
                <input type="text" class="form-input" id="edit_class" placeholder="مثال: قاعة 1" required>
            </div>
            <div class="form-group">
                <label class="form-label">المادة</label>
                <select class="form-input" id="edit_subject_id" required>
                    <?php
                    $subjectsQuery = "SELECT id, name FROM subjects";
                    $subjectsStmt = $db->query($subjectsQuery);
                    while ($subject = $subjectsStmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$subject['id']}'>{$subject['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="form-submit">حفظ التعديلات</button>
        </form>
    </div>
</div>

<style>
.schedule-list-section {
    margin-top: 2rem;
    padding: 1rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    width: 100%;
    clear: both;
}

.schedule-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.schedule-table th,
.schedule-table td {
    padding: 0.75rem;
    text-align: right;
    border-bottom: 1px solid #eee;
}

.schedule-table th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.actions {
    display: flex;
    gap: 0.5rem;
}

.edit-btn,
.delete-btn {
    padding: 0.25rem 0.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.edit-btn {
    background-color: #007bff;
    color: white;
}

.delete-btn {
    background-color: #dc3545;
    color: white;
}

.edit-btn:hover {
    background-color: #0056b3;
}

.delete-btn:hover {
    background-color: #c82333;
}

/* تعديل تنسيق الجدول الأسبوعي */
.weekly-schedule {
    width: 100%;
    margin-bottom: 2rem;
}

/* تعديل تنسيق القسم الرئيسي */
.admin-section {
    width: 100%;
    margin-bottom: 2rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal handling
    const scheduleModal = document.getElementById('scheduleModal');
    const openScheduleModalBtn = document.getElementById('openScheduleModal');
    const closeScheduleModalBtn = document.getElementById('closeScheduleModal');
    const scheduleForm = document.getElementById('scheduleForm');
    
    // Open modal
    openScheduleModalBtn.addEventListener('click', function() {
        scheduleModal.style.display = 'flex';
    });
    
    // Close modal
    closeScheduleModalBtn.addEventListener('click', function() {
        scheduleModal.style.display = 'none';
    });
    
    // Click outside to close
    window.addEventListener('click', function(event) {
        if (event.target === scheduleModal) {
            scheduleModal.style.display = 'none';
        }
    });
    
    // Form submission
    scheduleForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = {
            group_id: document.getElementById('group_id').value,
            day: document.getElementById('day').value,
            start_time: document.getElementById('start_time').value,
            end_time: document.getElementById('end_time').value,
            class: document.getElementById('class').value,
            subject_id: document.getElementById('subject_id').value
        };
        
        // Send data to server
        fetch('add_schedule.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to show new schedule
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حفظ الموعد');
        });
    });
    
    // Filter functionality
    const typeFilter = document.getElementById('typeFilter');
    const roomFilter = document.getElementById('roomFilter');
    const teacherFilter = document.getElementById('teacherFilter');
    
    function applyFilters() {
        const typeValue = typeFilter.value;
        const roomValue = roomFilter.value;
        const teacherValue = teacherFilter.value;
        
        document.querySelectorAll('.session-block').forEach(block => {
            let show = true;
            
            // Apply type filter
            if (typeValue !== 'all' && !block.classList.contains(typeValue)) {
                show = false;
            }
            
            // Apply room filter
            if (show && roomValue !== 'all') {
                const roomText = block.querySelector('.session-room').textContent;
                if (roomText !== roomValue) {
                    show = false;
                }
            }
            
            // Apply teacher filter
            if (show && teacherValue !== 'all') {
                const teacherId = block.dataset.teacherId;
                if (teacherId !== teacherValue) {
                    show = false;
                }
            }
            
            block.style.display = show ? 'block' : 'none';
        });
    }
    
    // Add event listeners to filters
    typeFilter.addEventListener('change', applyFilters);
    roomFilter.addEventListener('change', applyFilters);
    teacherFilter.addEventListener('change', applyFilters);
});

// Edit Schedule
function editSchedule(id) {
    // Fetch schedule data
    fetch('get_schedule.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const schedule = data.schedule;
                document.getElementById('edit_schedule_id').value = schedule.id;
                document.getElementById('edit_group_id').value = schedule.group_id;
                document.getElementById('edit_day').value = schedule.day;
                document.getElementById('edit_start_time').value = schedule.start_time;
                document.getElementById('edit_end_time').value = schedule.end_time;
                document.getElementById('edit_class').value = schedule.class;
                document.getElementById('edit_subject_id').value = schedule.subject_id;
                
                // Show modal
                document.getElementById('editScheduleModal').style.display = 'flex';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء جلب بيانات الموعد');
        });
}

// Delete Schedule
function deleteSchedule(id) {
    if (confirm('هل أنت متأكد من حذف هذا الموعد؟')) {
        fetch('delete_schedule.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الموعد');
        });
    }
}

// Edit Schedule Form Submission
document.getElementById('editScheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        id: document.getElementById('edit_schedule_id').value,
        group_id: document.getElementById('edit_group_id').value,
        day: document.getElementById('edit_day').value,
        start_time: document.getElementById('edit_start_time').value,
        end_time: document.getElementById('edit_end_time').value,
        class: document.getElementById('edit_class').value,
        subject_id: document.getElementById('edit_subject_id').value
    };
    
    fetch('update_schedule.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث الموعد');
    });
});

// Close Edit Modal
document.getElementById('closeEditModal').addEventListener('click', function() {
    document.getElementById('editScheduleModal').style.display = 'none';
});
</script>
</body>
</html>