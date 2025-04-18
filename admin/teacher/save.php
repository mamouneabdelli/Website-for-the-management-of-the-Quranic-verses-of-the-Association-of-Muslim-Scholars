<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/Progress.php';
require_once __DIR__ . '/../../classes/DBConnection.php';

$teacherId = 2;
$db = DBConnection::getConnection()->getDb();
$groupNames = Teacher::getGroups(
    $teacherId,
    $db
);



$attendances = [];

foreach($groupNames as $groupName) {
    $a = new Progress(
        $groupName['id'],
        $db
    );

    array_push($attendances,$a->getProggresses());
}



?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الحفظ والمراجعة</title>
    <link rel="stylesheet" href="css/save.css">
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
            <li>
                <a href="index.php">لوحة التحكم</a>
            </li>
            <li>
                <a href="attendance.php">الحضور والغياب</a>
            </li>
            <li style="background-color:#B0E4C4;">
                <a href="save.html">الحفظ والمراجعة</a>
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
            <button class="action-button">تسجيل متابعة جديدة</button>
        </div>

        <div class="student-progress-cards">
            <div class="student-card">
                <div class="student-header">
                    <div class="student-avatar">أ</div>
                    <div class="student-info">
                        <div class="student-name">أحمد محمد</div>
                        <div class="student-level">متقدم</div>
                    </div>
                </div>

                <div>
                    <div class="progress-title">نسبة الحفظ الكلية</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 75%;"></div>
                    </div>
                </div>

                <div class="memorization-details">
                    <div class="memorization-row">
                        <div class="memorization-label">السورة الحالية:</div>
                        <div class="memorization-value">سورة المائدة</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">الآيات المحفوظة:</div>
                        <div class="memorization-value">1-30</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">جودة الحفظ:</div>
                        <div class="memorization-value" style="color: #00A841;">ممتاز</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">آخر مراجعة:</div>
                        <div class="memorization-value">5 أبريل 2025</div>
                    </div>
                </div>

                <div class="record-button">
                    <button class="action-button">تسجيل المتابعة</button>
                </div>
            </div>

            <div class="student-card">
                <div class="student-header">
                    <div class="student-avatar">س</div>
                    <div class="student-info">
                        <div class="student-name">سارة عبدالله</div>
                        <div class="student-level">متوسط</div>
                    </div>
                </div>

                <div>
                    <div class="progress-title">نسبة الحفظ الكلية</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 45%;"></div>
                    </div>
                </div>

                <div class="memorization-details">
                    <div class="memorization-row">
                        <div class="memorization-label">السورة الحالية:</div>
                        <div class="memorization-value">سورة النساء</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">الآيات المحفوظة:</div>
                        <div class="memorization-value">1-50</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">جودة الحفظ:</div>
                        <div class="memorization-value" style="color: #2196F3;">جيد</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">آخر مراجعة:</div>
                        <div class="memorization-value">3 أبريل 2025</div>
                    </div>
                </div>

                <div class="record-button">
                    <button class="action-button">تسجيل المتابعة</button>
                </div>
            </div>

            <div class="student-card">
                <div class="student-header">
                    <div class="student-avatar">م</div>
                    <div class="student-info">
                        <div class="student-name">محمد علي</div>
                        <div class="student-level">مبتدئ</div>
                    </div>
                </div>

                <div>
                    <div class="progress-title">نسبة الحفظ الكلية</div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 20%;"></div>
                    </div>
                </div>

                <div class="memorization-details">
                    <div class="memorization-row">
                        <div class="memorization-label">السورة الحالية:</div>
                        <div class="memorization-value">سورة البقرة</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">الآيات المحفوظة:</div>
                        <div class="memorization-value">1-25</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">جودة الحفظ:</div>
                        <div class="memorization-value" style="color: #FB8C00;">متوسط</div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">آخر مراجعة:</div>
                        <div class="memorization-value">9 أبريل 2025</div>
                    </div>
                </div>

                <div class="record-button">
                    <button class="action-button">تسجيل المتابعة</button>
                </div>
            </div>
        </div>

        <div class="surah-progress-section">
            <div class="section-header">
                <div class="section-title">متابعة حفظ السور</div>
                <div>
                    <select class="filter-dropdown">
                        <option>جميع الطلاب</option>
                        <option>الطلاب المتقدمين</option>
                        <option>الطلاب المتوسطين</option>
                        <option>الطلاب المبتدئين</option>
                    </select>
                </div>
            </div>

            <div class="surah-grid">
                <div class="surah-card">
                    <div class="surah-name">سورة الفاتحة</div>
                    <div class="surah-progress">محفوظة 100%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 100%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة البقرة</div>
                    <div class="surah-progress">محفوظة 45%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 45%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة آل عمران</div>
                    <div class="surah-progress">محفوظة 30%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 30%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة النساء</div>
                    <div class="surah-progress">محفوظة 60%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 60%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة المائدة</div>
                    <div class="surah-progress">محفوظة 25%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 25%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة الأنعام</div>
                    <div class="surah-progress">محفوظة 10%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 10%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة الأعراف</div>
                    <div class="surah-progress">محفوظة 5%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 5%;"></div>
                    </div>
                </div>

                <div class="surah-card">
                    <div class="surah-name">سورة الأنفال</div>
                    <div class="surah-progress">محفوظة 0%</div>
                    <div class="progress-indicator">
                        <div class="progress-indicator-fill" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="memorization-table-section">
            <div class="section-header">
                <div class="section-title">سجل متابعة الحفظ والمراجعة</div>
                <div>
                    <select class="filter-dropdown">
                        <option>آخر أسبوع</option>
                        <option>آخر شهر</option>
                        <option>آخر 3 أشهر</option>
                        <option>الكل</option>
                    </select>
                </div>
            </div>

            <table class="memorization-table">
                <thead>
                <tr>
                    <th>الطالب</th>
                    <th>السورة</th>
                    <th>الآيات</th>
                    <th>نوع المتابعة</th>
                    <th>التقييم</th>
                    <th>التاريخ</th>
                    <th>ملاحظات</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>أحمد محمد</td>
                    <td>سورة المائدة</td>
                    <td>20-30</td>
                    <td>حفظ جديد</td>
                    <td><span class="memorization-status status-excellent">ممتاز</span></td>
                    <td>9 أبريل 2025</td>
                    <td>متقن للحفظ مع تجويد ممتاز</td>
                </tr>
                <tr>
                    <td>سارة عبدالله</td>
                    <td>سورة النساء</td>
                    <td>40-50</td>
                    <td>حفظ جديد</td>
                    <td><span class="memorization-status status-good">جيد</span></td>
                    <td>8 أبريل 2025</td>
                    <td>بحاجة لمراجعة قواعد التجويد</td>
                </tr>
                <tr>
                    <td>محمد علي</td>
                    <td>سورة البقرة</td>
                    <td>15-25</td>
                    <td>حفظ جديد</td>
                    <td><span class="memorization-status status-average">متوسط</span></td>
                    <td>8 أبريل 2025</td>
                    <td>بحاجة إلى مزيد من المراجعة</td>
                </tr>
                <tr>
                    <td>أحمد محمد</td>
                    <td>سورة المائدة</td>
                    <td>1-20</td>
                    <td>مراجعة</td>
                    <td><span class="memorization-status status-excellent">ممتاز</span></td>
                    <td>5 أبريل 2025</td>
                    <td>حفظ متقن جدًا</td>
                </tr>
                <tr>
                    <td>نورة أحمد</td>
                    <td>سورة الفاتحة</td>
                    <td>كاملة</td>
                    <td>مراجعة</td>
                    <td><span class="memorization-status status-good">جيد</span></td>
                    <td>3 أبريل 2025</td>
                    <td>تحسن ملحوظ في الأداء</td>
                </tr>
                <tr>
                    <td>رامي خالد</td>
                    <td>سورة البقرة</td>
                    <td>1-10</td>
                    <td>حفظ جديد</td>
                    <td><span class="memorization-status status-needs-review">يحتاج مراجعة</span></td>
                    <td>1 أبريل 2025</td>
                    <td>يواجه صعوبة في الحفظ، يحتاج تدريب إضافي</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // تفعيل بطاقات السور
    document.querySelectorAll('.surah-card').forEach(card => {
        card.addEventListener('click', function() {
            const surahName = this.querySelector('.surah-name').textContent;
            alert('تم اختيار: ' + surahName);
        });
    });
</script>
</body>
</html>