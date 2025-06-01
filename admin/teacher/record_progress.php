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
$groupNames = Teacher::getGroups($teacherId, $db);


$students = [];
$selectedGroupId = isset($_POST['group_id']) ? $_POST['group_id'] : '';
$progressDate = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');


$surahs = [
    ['id' => 1, 'name' => 'الفاتحة'],
    ['id' => 2, 'name' => 'البقرة'],
    ['id' => 3, 'name' => 'آل عمران'],
    ['id' => 4, 'name' => 'النساء'],
    ['id' => 5, 'name' => 'المائدة'],
    ['id' => 6, 'name' => 'الأنعام'],
    ['id' => 7, 'name' => 'الأعراف'],
    ['id' => 8, 'name' => 'الأنفال']
];

$types = [
        'مراجعة',
        'حفظ جديد'
];



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_progress'])) {
    $groupId = $_POST['group_id'];
    $studentId = $_POST['student_id'];
    $surah = $_POST['surah_name'];
    $ayah = $_POST['ayah'];
    $evaluation = $_POST['evaluation'];
    $note = $_POST['note'];
    $date = $_POST['date'];
    $progress = $_POST['progress'];



    try {
        $query = $db->prepare("
    INSERT INTO academic_progress (student_id,group_id,sourah,ayah,evaluation,progress_type,date,note)
    VALUES (?,?,?,?,?,?,?,?)
    ");
        $query->execute([$studentId,$groupId,$surah,$ayah,$evaluation,$progress,$date,$note]);
    }catch (PDOException $e) {
        die("Error : ". $e->getMessage());
    }
    header('Location: save.php?message=Progress recorded successfully');
    exit;
}

$progress = new Progress(
  $selectedGroupId,
  $db  
);

if ($selectedGroupId) {
    $students = $progress->getStudents();
}

?>

<link rel="stylesheet" href="css/save.css">
    <style>
        .container {
            display: flex;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group select,
        .form-group input[type="date"],
        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .form-group textarea {
            max-width: 500px;
            height: 100px;
            resize: vertical;
        }

        .submit-btn {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #218838;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #007bff;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>


    <div class="content">
        <a href="save.php" class="back-link"><i class="fas fa-arrow-right"></i> العودة إلى الحفظ والمراجعة</a>
        <h2>تسجيل متابعة جديدة</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="groupSelect">المجموعة:</label>
                <select id="groupSelect" name="group_id" required onchange="this.form.submit()">
                    <option value="">اختر المجموعة</option>
                    <?php foreach ($groupNames as $group) { ?>
                        <option value="<?= $group['id'] ?>" <?= $selectedGroupId == $group['id'] ? 'selected' : '' ?>>
                            <?= $group['group_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <?php if ($students) { ?>
                <div class="form-group">
                    <label for="studentSelect">الطالب:</label>
                    <select id="studentSelect" name="student_id" required>
                        <option value="">اختر الطالب</option>
                        <?php foreach ($students as $student) { ?>
                            <option value="<?= $student['id'] ?>">
                                <?= $student['first_name'] . ' ' . $student['last_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <div class="form-group">
                <label for="surahSelect">السورة:</label>
                <select id="surahSelect" name="surah_name" required>
                    <option value="">اختر السورة</option>
                    <?php foreach ($surahs as $surah) { ?>
                        <option value="<?= $surah['name'] ?>"><?= $surah['name'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="surahSelect">نوع المتابعة:</label>
                <select id="surahSelect" name="progress" required>
                    <option value="">اختر النوع</option>
                    <?php foreach ($types as $type) { ?>
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ayah">الآيات المحفوظة:</label>
                <input type="text" id="ayah" name="ayah" placeholder="مثال: 1-5" required>
            </div>

            <div class="form-group">
                <label for="evaluation">التقييم:</label>
                <select id="evaluation" name="evaluation" required>
                    <option value="">اختر التقييم</option>
                    <option value="ممتاز">ممتاز</option>
                    <option value="جيد">جيد</option>
                    <option value="متوسط">متوسط</option>
                    <option value="يحتاج مراجعة">يحتاج مراجعة</option>
                </select>
            </div>

            <div class="form-group">
                <label for="note">ملاحظات:</label>
                <textarea id="note" name="note" placeholder="أدخل أي ملاحظات إضافية"></textarea>
            </div>

            <div class="form-group">
                <label for="progressDate">التاريخ:</label>
                <input type="date" id="progressDate" name="date" value="<?= $progressDate ?>" required>
            </div>

            <button type="submit" name="submit_progress" class="submit-btn">حفظ المتابعة</button>
        </form>
    </div>
</div>
</body>
</html>