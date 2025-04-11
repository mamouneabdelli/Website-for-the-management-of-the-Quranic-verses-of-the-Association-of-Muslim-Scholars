<?php

require_once __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Student.php';


$studentId = $_SESSION['student_id']['id'];
$db = DBConnection::getConnection()->getDb();

$grades = Student::getGrades($studentId, $db);


if(!empty($grades)) {
    $status = $grades[0]['status'];
    $bgColor = match ($status) {
        'ناجح' => '#d4edda',
        'راسب' => '#f8d7da',
        'غياب' => '#fff3cd',
        default => '#e2e3e5',
    };
}
?>

<!-- Grades Section -->
<div class="full-width-container">
    <div class="schedule-section">
        <div class="schedule-title">علامات الاختبارات <span>النتائج الحالية</span></div>
        <div style="padding: 10px;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <thead>
                    <tr>
                        <th style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">المادة</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">العلامة</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">التاريخ</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">الحالة</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($grades as $grade) {
                    ?>
                        <tr>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;"><?= $grade ? $grade['subject_name'] : "" ?></td>
                            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee; font-weight: bold; color: #27ae60;"><?= $grade ? $grades[0]['grade'] : "" ?>/100</td>
                            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;"><?= $grade ? $grade['date'] : "" ?></td>
                            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                                <span style="background-color: <?= $bgColor ?>; padding: 4px 8px; border-radius: 4px;">
                                    <?= $status ?>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php

require_once __DIR__ . '/../template/footer.php';

?>