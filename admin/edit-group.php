<?php
ob_start();

$ac_session = "active";
require_once __DIR__ .'/template/header.php';

// Check if database connection exists
if (!isset($db) || !$db) {
    die("Database connection not available");
}

if (!isset($_GET['id'])) {
    header("Location: admin-sessions.php");
    exit;
}

$group_id = $_GET['id'];

try {
    // Get group details
    $query = $db->prepare("
        SELECT g.*, 
               CONCAT(u.first_name, ' ', u.last_name) as teacher_name
        FROM groups g
        LEFT JOIN teachers t ON g.teacher_id = t.id
        LEFT JOIN users u ON t.user_id = u.id
        WHERE g.id = ?
    ");
    $query->execute([$group_id]);
    $group = $query->fetch(PDO::FETCH_ASSOC);

    if (!$group) {
        header("Location: admin-sessions.php");
        exit;
    }

    // Get curriculum
    $curriculum_query = $db->prepare("
        SELECT c.*, s.name as subject_name
        FROM curriculum c
        LEFT JOIN subjects s ON c.subject_id = s.id
        WHERE c.group_id = ?
    ");
    $curriculum_query->execute([$group_id]);
    $curriculum = $curriculum_query->fetchAll(PDO::FETCH_ASSOC);

    // Initialize empty curriculum array if no data exists
    if (!$curriculum) {
        $curriculum = [];
    }

    // Get all teachers for dropdown
    $teachers_query = $db->prepare("
        SELECT t.id, CONCAT(u.first_name, ' ', u.last_name) as teacher_name
        FROM teachers t
        JOIN users u ON t.user_id = u.id
    ");
    $teachers_query->execute();
    $teachers = $teachers_query->fetchAll(PDO::FETCH_ASSOC);

    // Get all subjects for dropdown
    $subjects_query = $db->prepare("SELECT * FROM subjects");
    $subjects_query->execute();
    $subjects = $subjects_query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "حدث خطأ في قاعدة البيانات: " . $e->getMessage();
    header("Location: admin-sessions.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_group'])) {
    try {
        $db->beginTransaction();
        
        // Update group
        $update_group = $db->prepare("
            UPDATE groups 
            SET group_name = ?,
                capacity = ?,
                academic_year = ?,
                start_date = ?,
                teacher_id = ?,
                description = ?
            WHERE id = ?
        ");
        
        $update_group->execute([
            $_POST['group_name'],
            $_POST['capacity'],
            $_POST['academic_year'],
            $_POST['start_date'],
            $_POST['teacher_id'],
            $_POST['description'],
            $group_id
        ]);
        
        // Delete existing curriculum only if it exists
        if (!empty($curriculum)) {
            $delete_curriculum = $db->prepare("DELETE FROM curriculum WHERE group_id = ?");
            $delete_curriculum->execute([$group_id]);
        }
        
        $db->commit();
        $_SESSION['success'] = "تم تحديث الحلقة بنجاح";
        header("Location: admin-sessions.php");
        exit;
    } catch (Exception $e) {
        $db->rollBack();
        $_SESSION['error'] = "حدث خطأ أثناء تحديث الحلقة: " . $e->getMessage();
    }
}
?>

<div class="content">
    <div class="admin-section">
        <div class="section-title">
            تعديل الحلقة
            <span><?php echo htmlspecialchars($group['group_name']); ?></span>
        </div>

        <form method="POST" action="" class="edit-form">
            <div class="form-group">
                <label class="form-label">اسم الحلقة</label>
                <input type="text" name="group_name" class="form-input" required 
                       value="<?php echo htmlspecialchars($group['group_name']); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">الأستاذ المشرف</label>
                <select name="teacher_id" class="form-input" required>
                    <option value="">اختر الأستاذ</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>" 
                                <?php echo $teacher['id'] == $group['teacher_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($teacher['teacher_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">السنة الدراسية</label>
                <input type="text" name="academic_year" class="form-input" required
                       value="<?php echo htmlspecialchars($group['academic_year']); ?>">
            </div>

            <div class="form-group">
                <label class="form-label">تاريخ البدء</label>
                <input type="date" name="start_date" class="form-input" required
                       value="<?php echo $group['start_date']; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">السعة</label>
                <input type="number" name="capacity" class="form-input" required
                       value="<?php echo $group['capacity']; ?>">
            </div>

            <div class="form-group">
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-input"><?php echo htmlspecialchars($group['description']); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="edit_group" class="form-submit">حفظ التغييرات</button>
                <a href="admin-sessions.php" class="cancel-btn">إلغاء</a>
            </div>
        </form>
    </div>
</div>

<style>
.content {
    padding: 20px;
    max-width: 1200px;
    width: 100%;
}

.admin-section {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 25px;
}

.section-title {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #eee;
}

.section-title span {
    color: #666;
    font-size: 18px;
    margin-right: 10px;
}

.edit-form {
    max-width: 800px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #444;
}

.form-input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-input:focus {
    border-color: #4a90e2;
    outline: none;
    box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
}

select.form-input {
    background-color: #fff;
    cursor: pointer;
}

textarea.form-input {
    min-height: 100px;
    resize: vertical;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
}

.form-submit {
    padding: 12px 24px;
    background-color: #4a90e2;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.form-submit:hover {
    background-color: #357abd;
}

.cancel-btn {
    padding: 12px 24px;
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.cancel-btn:hover {
    background-color: #c82333;
}

/* Days selection styling */
.form-group div[style*="display: flex"] {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
    border: 1px solid #eee;
}

.form-group div[style*="display: flex"] label {
    background: white;
    padding: 8px 15px;
    border-radius: 4px;
    border: 1px solid #ddd;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-group div[style*="display: flex"] label:hover {
    background: #f0f0f0;
}

.form-group div[style*="display: flex"] input[type="checkbox"] {
    margin-left: 8px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .content {
        padding: 10px;
    }
    
    .admin-section {
        padding: 15px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-submit,
    .cancel-btn {
        width: 100%;
        text-align: center;
    }
}
</style> 

<?php 
ob_end_flush();

?>