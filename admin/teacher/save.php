<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/Progress.php';
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


$progresses = [];

foreach($groupNames as $groupName) {
    
    $a = new Progress(
        $groupName['id'],
        $db
    );

    array_push($progresses,$a->getProggresses());
}

// echo "<pre>";
//print_r($progresses);
//echo "</pre>";
?>

<link rel="stylesheet" href="css/save.css">


    <div class="content">
        <div class="search-bar">
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="بحث عن الطالب">
            </div>
            <a class="action-button" href="record_progress.php">تسجيل متابعة جديدة</a>
        </div>

        <div class="student-progress-cards">

            <?php
            if (!empty($progresses)) {
            foreach($progresses as $progresseGroup) {
                foreach($progresseGroup as $progresse) {    

                    $bgColor = match ($progresse['evaluation']) {
                        'ممتاز' => 'status-excellent',
                        'جيد' => 'status-good',
                        'متوسط' => 'status-average',
                        'يحتاج مراجعة' => 'status-needs-review',
                        default => '#e2e3e5',
                    };
            ?>
            <div class="student-card">
                <div class="student-header">
                    <div class="student-avatar">أ</div>
                    <div class="student-info">
                        <div class="student-name"><?= $progresse['first_name'] . " " . $progresse['last_name'] ?></div>
                        <div class="student-level"><?= $progresse['evaluation'] ?></div>
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
                        <div class="memorization-value">سورة <?= $progresse['sourah'] ?></div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">الآيات المحفوظة:</div>
                        <div class="memorization-value"><?= $progresse['ayah'] ?></div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">جودة الحفظ:</div>
                        <div ><span class="memorization-status <?= $bgColor ?>"><?= $progresse['evaluation'] ?></span></div>
                    </div>
                    <div class="memorization-row">
                        <div class="memorization-label">آخر مراجعة:</div>
                        <div class="memorization-value"><?= $progresse['date'] ?></div>
                    </div>
                </div>

                <div class="record-button">
                    <button class="action-button">تسجيل المتابعة</button>
                </div>
            </div>

            <?php
                }
            }
            }
            ?>
            
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
            <?php
            // استخدام مصفوفة لتخزين أسماء المجموعات التي تم معالجتها
            $processedGroups = [];
            foreach($progresses as $index => $progresseGroup) {
                // تخطي المجموعات الفارغة
                if (empty($progresseGroup)) {
                    continue;
                }
                
                // الحصول على اسم المجموعة
                $groupName = '';
                if (isset($progresseGroup[0]['group_name'])) {
                    $groupName = $progresseGroup[0]['group_name'];
                } elseif (isset($groupNames[$index]['group_name'])) {
                    $groupName = $groupNames[$index]['group_name'];
                }
                
                // تخطي المجموعات المكررة
                if (in_array($groupName, $processedGroups)) {
                    continue;
                }
                $processedGroups[] = $groupName;
             ?>
            <div class="section-header">
                <div class="section-title"><?= $groupName ?></div>
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
                <?php
                if (!empty($progresseGroup)) {
            foreach($progresseGroup as $progresse) { 
                $bgColor = match ($progresse['evaluation']) {
                    'ممتاز' => 'status-excellent',
                    'جيد' => 'status-good',
                    'متوسط' => 'status-average',
                    'يحتاج مراجعة' => 'status-needs-review',
                    default => '#e2e3e5',
                };
             ?>
                <tr>
                    <td><?= $progresse['first_name'] . " " . $progresse['last_name'] ?></td>
                    <td>سورة <?= $progresse['sourah'] ?></td>
                    <td><?= $progresse['ayah'] ?></td>
                    <td>حفظ جديد</td>
                    <td><span class="memorization-status <?= $bgColor ?>"><?= $progresse['evaluation'] ?></span></td>
                    <td><?= $progresse['date'] ?></td>
                    <td><?= $progresse['note'] ?></td>
                </tr>
                <?php } }?>
               
                </tbody>
            </table>
            <?php
            } 
             ?>
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