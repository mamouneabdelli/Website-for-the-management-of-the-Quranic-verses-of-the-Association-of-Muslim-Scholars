<?php

require_once __DIR__ . '/template/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Progress.php';
require_once __DIR__ . '/../../classes/Student.php';
require_once __DIR__ . '/../../classes/Teacher.php';




$studentId = $_SESSION['student_id'];

$db = DBConnection::getConnection()->getDb();


$groupId = Student::getGroupId($studentId, $db);

$progresses = Student::getProggresses($studentId, $db);


?>


<link rel="stylesheet" href="css/progress.css">

<style>
    .status-excellent {
    background-color: #E6F7E9;
    color: #00A841;
}

.status-good {
    background-color: #E3F2FD;
    color: #2196F3;
}

.status-average {
    background-color: #FFF3E0;
    color: #FB8C00;
}

.status-needs-review {
    background-color: #FFE6E6;
    color: #FF5252;
}
</style>

        <div class="content">
            <div class="progress-trend">
                <div class="section-title">
                    اتجاه التقدم
                    <span>آخر 3 أسابيع</span>
                </div>
                <div class="trend-chart">
                    <div class="trend-bar" style="height: 60%;"></div>
                    <div class="trend-bar" style="height: 40%;"></div>
                    <div class="trend-bar" style="height: 80%;"></div>
                </div>
                <div class="trend-labels">
                    <span>الأسبوع 1</span>
                    <span>الأسبوع 2</span>
                    <span>الأسبوع 3</span>
                </div>
            </div>

            <div class="progress-section">
                <div class="section-title">
                    متابعة التقدم
                    <span>إجمالي: 3 تقييمات</span>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في التقييمات...">
                </div>
                <table class="progress-table">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>السورة</th>
                            <th>الآيات</th>
                            <th>التقييم</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($progresses as $progresse) { 
                            $bgColor = match ($progresse['evaluation']) {
                                'ممتاز' => 'status-excellent',
                                'جيد' => 'status-good',
                                'متوسط' => 'status-average',
                                'يحتاج مراجعة' => 'status-needs-review',
                                default => '#e2e3e5',
                            };
                            ?>
                        <tr>
                            <td><?= $progresse['date'] ?></td>
                            <td>سورة <?= $progresse['sourah'] ?></td>
                            <td>1-10</td>
                            <td><span class="evaluation <?= $bgColor ?>"><?= $progresse['evaluation'] ?></span></td>
                            <td><?= $progresse['note'] ?></td>
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