<?php

require_once __DIR__ . '/template/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Progress.php';
require_once __DIR__ . '/../../classes/Student.php';
require_once __DIR__ . '/../../classes/Teacher.php';




$studentId = $_SESSION['student_id']['id'];
$user_id = $_SESSION['user_id'];

$db = DBConnection::getConnection()->getDb();


$groupId = Student::getGroupId($studentId, $db);

$progresses = Student::getProggresses($studentId, $db);

try {
    $query = $db->prepare("
SELECT * FROM users WHERE id=?
");
    $query->execute([$user_id]);
    $user = $query->fetchAll(PDO::FETCH_ASSOC);

    $query = $db->prepare("
SELECT * FROM students WHERE id=?
");
    $query->execute([$studentId]);
    $student = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}


?>
<link rel="stylesheet" href="css/profile.css">

<div class="content">
    <div class="profile-section">
        <div class="section-title">
            الملف الشخصي
            <button class="edit-btn" id="editProfileBtn"><i class="fas fa-edit"></i> تعديل الملف</button>
        </div>
        <div class="profile-header">
            <div class="profile-avatar">
                <?= mb_substr($user[0]['first_name'], 0, 1, "UTF-8") ?>
            </div>

            <div class="profile-info">
                <h2><?= $user[0]['first_name'] . " " . $user[0]['last_name'] ?></h2>
                <p>طالب في قسم <?= $groupId[0]['group_name'] ?> </p>
            </div>
        </div>
        <div class="profile-details">
            <div class="detail-item">
                <i class="fas fa-id-card"></i>
                <div>
                    <label>رقم الطالب</label>
                    <span><?= $user[0]['id'] ?></span>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-users"></i>
                <div>
                    <label>المجموعة</label>
                    <span><?= $groupId[0]['group_name'] ?></span>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-envelope"></i>
                <div>
                    <label>البريد الإلكتروني</label>
                    <span><?= $user[0]['email'] ?></span>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-phone"></i>
                <div>
                    <label>رقم الهاتف</label>
                    <span><?= $student[0]['parent_phone'] ?></span>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-calendar-alt"></i>
                <div>
                    <label>تاريخ التسجيل</label>
                    <span><?= date("Y-m-d", strtotime($user[0]['created_at'])) ?></span>
                </div>
            </div>
            <div class="detail-item">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <label>العنوان</label>
                    <span><?= $student[0]['address'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="progress-summary">
        <div class="section-title">
            ملخص التقدم
        </div>
        <div class="summary-item">
            <i class="fas fa-check-circle"></i>
            <div>
                <label>إجمالي التقييمات</label>
                <span><?= count($progresses) ?></span>
            </div>
        </div>
        <div class="summary-item">
            <i class="fas fa-star"></i>
            <div>
                <label>متوسط التقييم</label>
                <span>4.0/5</span>
            </div>
        </div>
        <div class="summary-item">
            <i class="fas fa-medal"></i>
            <div>
                <label>آخر تقييم</label>
                <span><?= $progresses[0]['evaluation'] ?> (<?= $progresses[0]['date'] ?>)</span>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal" id="editProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">تعديل الملف الشخصي</div>
            <button class="close-btn" id="closeEditModal">×</button>
        </div>
        <div class="modal-body">
            <label>البريد الإلكتروني</label>
            <input type="email" value="ahmed.ali@example.com">
            <label>رقم الهاتف</label>
            <input type="tel" value="+213 123 456 789">
            <button>حفظ التغييرات</button>
        </div>
    </div>
</div>

<script>
    const editProfileModal = document.getElementById('editProfileModal');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const closeEditModal = document.getElementById('closeEditModal');

    editProfileBtn.addEventListener('click', () => {
        editProfileModal.style.display = 'flex';
    });

    closeEditModal.addEventListener('click', () => {
        editProfileModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === editProfileModal) {
            editProfileModal.style.display = 'none';
        }
    });

    document.querySelector('.modal-body button').addEventListener('click', () => {
        alert('حفظ التغييرات قيد التطوير! يرجى إضافة منطق الحفظ لاحقًا.');
    });
</script>
<script type="text/javascript">
    var gk_isXlsx = false;
    var gk_xlsxFileLookup = {};
    var gk_fileData = {};

    function filledCell(cell) {
        return cell !== '' && cell != null;
    }

    function loadFileData(filename) {
        if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
            try {
                var workbook = XLSX.read(gk_fileData[filename], {
                    type: 'base64'
                });
                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];

                // Convert sheet to JSON to filter blank rows
                var jsonData = XLSX.utils.sheet_to_json(worksheet, {
                    header: 1,
                    blankrows: false,
                    defval: ''
                });
                // Filter out blank rows (rows where all cells are empty, null, or undefined)
                var filteredData = jsonData.filter(row => row.some(filledCell));

                // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
                var headerRowIndex = filteredData.findIndex((row, index) =>
                    row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
                );
                // Fallback
                if (headerRowIndex === -1 || headerRowIndex > 25) {
                    headerRowIndex = 0;
                }

                // Convert filtered JSON back to CSV
                var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
                csv = XLSX.utils.sheet_to_csv(csv, {
                    header: 1
                });
                return csv;
            } catch (e) {
                console.error(e);
                return "";
            }
        }
        return gk_fileData[filename] || "";
    }
</script>
</body>

</html>