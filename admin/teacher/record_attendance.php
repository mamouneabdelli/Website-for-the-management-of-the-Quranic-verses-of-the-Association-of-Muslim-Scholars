<?php

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/Attendance.php';
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


// Initialize variables
$students = [];
$selectedGroupId = isset($_POST['group_id']) ? $_POST['group_id'] : '';
$attendanceDate = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');

if(!empty($selectedGroupId)) {
    $a = new Attendance(
        $selectedGroupId,
        $db
    );

    $students = $a->getStudents();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_attendance'])) {
    $groupId = $_POST['group_id'];
    $date = $_POST['date'];
    $attendances = $_POST['attendance'] ;

    foreach ($attendances as $studentId => $data) {
        $status = $data['status'];

        try {
        $query = $db->prepare("
            INSERT INTO attendance (date,status,student_id,group_id,created_by)
            VALUES (?,?,?,?,?)
        ");

        $query->execute([$date,$status,$studentId,$groupId,$teacherId]);
        $successList[] = $studentId;
        }catch(PDOException $e) {
            $errorList[] = "خطأ عند الطالب ID: $studentId - " . $e->getMessage();
        }

    }

    header('Location: attendance.php?message=Attendance recorded successfully');
   exit;
}

//print_r($errorList);

?>

<link rel="stylesheet" href="css/style.css">
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
        .form-group input[type="date"] {
            width: 100%;
            max-width: 300px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: right;
        }

        .attendance-table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }

        .status-buttons {
            display: flex;
            gap: 10px;
        }

        .status-radio {
            display: none;
        }

        .status-label {
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .status-label.present {
            background-color: #d4edda;
            color: #155724;
        }

        .status-label.absent {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-label.late {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-radio:checked + .status-label {
            font-weight: bold;
            border: 2px solid #333;
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
        <a href="attendance.php" class="back-link"><i class="fas fa-arrow-right"></i> العودة إلى الحضور والغياب</a>
        <h2>تسجيل الحضور</h2>
        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
            <div class="form-group">
                <label for="groupSelect">المجموعة:</label>
                <select id="groupSelect" name="group_id" required onchange="this.form.submit()">
                    <option value="" hidden >اختر المجموعة</option>
                    <?php foreach ($groupNames as $group) { ?>
                        <option value="<?= $group['id'] ?>" <?= $selectedGroupId == $group['id'] ? 'selected' : '' ?>>
                            <?= $group['group_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="attendanceDate">التاريخ:</label>
                <input type="date" id="attendanceDate" name="date" value="<?= $attendanceDate ?>" required>
            </div>

            <?php if ($students) { ?>
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>الطالب</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student) { ?>
                            <tr>
                                <td>
                                    <?= $student['first_name'] . ' ' . $student['last_name'] ?> (ID: <?= $student['id'] ?>)
                                </td>
                                <td>
                                    <div class="status-buttons">
                                        <input type="radio" id="present_<?= $student['id'] ?>" name="attendance[<?= $student['id'] ?>][status]" value="حاضر" class="status-radio" required>
                                        <label for="present_<?= $student['id'] ?>" class="status-label present">حاضر</label>

                                        <input type="radio" id="absent_<?= $student['id'] ?>" name="attendance[<?= $student['id'] ?>][status]" value="غائب" class="status-radio">
                                        <label for="absent_<?= $student['id'] ?>" class="status-label absent">غائب</label>

                                        <input type="radio" id="late_<?= $student['id'] ?>" name="attendance[<?= $student['id'] ?>][status]" value="متأخر" class="status-radio">
                                        <label for="late_<?= $student['id'] ?>" class="status-label late">متأخر</label>
                                    </div>
                                    
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <button type="submit" name="submit_attendance" class="submit-btn">حفظ الحضور</button>
            <?php } ?>
        </form>
    </div>
</div>
</body>
</html>