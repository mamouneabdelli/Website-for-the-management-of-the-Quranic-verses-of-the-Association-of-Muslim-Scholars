<?php
$index = "active";
require_once __DIR__ . '/template/header.php';


$query = $db->prepare("
    SELECT
        teachers.id as teacher_id ,
        teachers.specialization ,
        users.first_name,
        users.last_name,
        users.created_at
        FROM teachers
    JOIN users ON teachers.user_id = users.id
");
$query->execute();
$teachers = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $db->prepare("
    SELECT * FROM students
");
$query->execute();
$students = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $db->prepare("
    SELECT * FROM groups
");
$query->execute();
$groups = $query->fetchAll(PDO::FETCH_ASSOC);

$query = $db->prepare("
    SELECT status FROM attendance
");
$query->execute();
$attendances = $query->fetchAll(PDO::FETCH_ASSOC);


$presents = count(array_filter($attendances, fn($a) => $a['status'] == "حاضر"));

$num = count($attendances);

if($num != 0)
    $percentage = ($presents * 100) / $num;

$query = $db->prepare("
    SELECT * FROM messages
");
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);


//echo "<pre>";
//print_r($teachers);
//echo "</pre>";

?>

 <link rel="stylesheet" href="CSS/style.css">

    <div class="content">
        <div class="search-bar">
            <a class="add-btn" href="index.php">
                <i class="fas fa-sync-alt"></i>تحديث النظام
            </a>
        </div>

        <div class="stats-cards">
            <div class="stat-card">
                <div class="number blue"><?= count($teachers) ?></div>
                <div class="label">إجمالي الأساتذة</div>
            </div>
            <div class="stat-card">
                <div class="number green"><?= count($students) ?></div>
                <div class="label">إجمالي الطلاب</div>
            </div>
            <div class="stat-card">
                <div class="number red"><?= count($groups) ?></div>
                <div class="label">اجمالي الحلقات</div>
            </div>
            <div class="stat-card">
                <div class="number orange"><?= isset($percentage) ? number_format($percentage, 2) : " " ?>%</div>
                <div class="label">نسبة الحضور</div>
            </div>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-blue">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="dashboard-card-number"><?= count($teachers) ?></div>
                <div class="dashboard-card-title">أساتذة جدد هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-up"></i> 18% مقارنة بالشهر الماضي
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="dashboard-card-number"><?= count($students) ?></div>
                <div class="dashboard-card-title">طلاب جدد هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-up"></i> 23% مقارنة بالشهر الماضي
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-red">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="dashboard-card-number"><?= count($groups) ?></div>
                <div class="dashboard-card-title">حلقات مكتملة هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-up"></i> 12% مقارنة بالشهر الماضي
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-orange">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="dashboard-card-number"><?= count($messages) ?></div>
                <div class="dashboard-card-title">رسائل جديدة هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-down"></i> 5% مقارنة بالشهر الماضي
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="section-title">
                أحدث الأساتذة المنضمين
                <span class="view-all"><a href="admin-teachers.php" class="view-all">عرض الكل</a></span>
            </div>
            <table class="admin-table">
                <thead>
                <tr>
                    <th>اسم الأستاذ</th>
                    <th>تاريخ الانضمام</th>
                    <th>الحلقات</th>
                    <th>الطور</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($teachers as $teacher) :
                    $query = $db->prepare("
    SELECT * FROM group_teachers WHERE teacher_id=?
");
                    $query->execute([$teacher['teacher_id']]);
                    $groups = $query->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td><?= $teacher['first_name'] ." " . $teacher['last_name']  ?></td>
                    <td><?=date("Y-m-d",strtotime($teacher['created_at'])) ?></td>
                    <td><?= count($groups) ?></td>
                    <td><span class="status status-active">تعليم القرأن الكريم</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                            <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <div class="tabs">
                <div class="tab active">النشاط الأخير</div>
            </div>

            <div class="notification-list">
                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تم تسجيل طالب جديد</div>
                        <div class="notification-message">تم تسجيل الطالب عبد الله محمد في حلقة القرآن رقم 2</div>
                        <div class="notification-time">قبل 10 دقائق</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تقرير جديد</div>
                        <div class="notification-message">قام الأستاذ محمد علي بإرسال تقرير أداء الطلاب لشهر أبريل</div>
                        <div class="notification-time">قبل ساعة واحدة</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تنبيه حول نسبة الغياب</div>
                        <div class="notification-message">ارتفعت نسبة الغياب في حلقة القرآن رقم 3 إلى 20%</div>
                        <div class="notification-time">قبل 3 ساعات</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تم إنشاء حلقة جديدة</div>
                        <div class="notification-message">تم إنشاء حلقة القرآن رقم 5 بواسطة الأستاذ أحمد رامي</div>
                        <div class="notification-time">قبل 5 ساعات</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">إنجاز جديد</div>
                        <div class="notification-message">أكمل الطالب محمد عبد الله حفظ سورة البقرة</div>
                        <div class="notification-time">قبل 7 ساعات</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="section-title">نشاط الحلقات (آخر 7 أيام)</div>
            <div class="chart-container">
                <div class="chart-bars">
                    <div class="chart-bar" style="height: 65%;" data-value="65%"></div>
                    <div class="chart-bar" style="height: 80%;" data-value="80%"></div>
                    <div class="chart-bar" style="height: 95%;" data-value="95%"></div>
                    <div class="chart-bar" style="height: 75%;" data-value="75%"></div>
                    <div class="chart-bar" style="height: 85%;" data-value="85%"></div>
                    <div class="chart-bar" style="height: 90%;" data-value="90%"></div>
                    <div class="chart-bar" style="height: 70%;" data-value="70%"></div>
                </div>
                <div class="chart-labels">
                    <div class="chart-label">الجمعة</div>
                    <div class="chart-label">السبت</div>
                    <div class="chart-label">الأحد</div>
                    <div class="chart-label">الإثنين</div>
                    <div class="chart-label">الثلاثاء</div>
                    <div class="chart-label">الأربعاء</div>
                    <div class="chart-label">الخميس</div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // يمكن إضافة التفاعل