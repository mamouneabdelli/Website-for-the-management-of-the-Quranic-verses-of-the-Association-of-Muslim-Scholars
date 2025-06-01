<?php
$ac_teacher = "active";
require_once __DIR__ . '/template/header.php';

$user_type = "teacher";
$order = $_GET['order'] ?? 'newest';
switch ($order) {
    case 'oldest':
        $orderBy = 'id ASC';
        break;
    case 'name':
        $orderBy = 'first_name ASC, last_name ASC';
        break;
    case 'newest':
    default:
        $orderBy = 'id DESC';
        break;
}
$query = $db->prepare("SELECT * FROM users WHERE user_type = ? ORDER BY $orderBy");
$query->execute([$user_type]);
$teachers = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize errors array
$errors = [];

if (isset($_POST))
    require_once __DIR__ . '/includes/add-teacher.php';

?>

<link rel="stylesheet" href="CSS/admin-teachers.css">

<div class="content">
    <?php if (isset($_GET['has_groups']) && $_GET['has_groups'] == 1): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i> لا يمكن حذف الأستاذ لأنه مسؤول عن مجموعة واحدة أو أكثر. يجب حذف المجموعات المرتبطة به أولاً من صفحة إدارة المجموعات.
    </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> تم حذف الأستاذ بنجاح.
    </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> حدث خطأ أثناء محاولة حذف الأستاذ. الرجاء المحاولة مرة أخرى.
    </div>
    <?php endif; ?>
    
    <div class="search-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="بحث عن أستاذ...">
        </div>
        <button class="add-btn" id="openAddTeacherModal">
            <i class="fas fa-plus"></i> إضافة أستاذ جديد
        </button>
    </div>

    <div class="filter-section">
        <div class="filter-title">تصفية النتائج</div>
        <div class="filter-options">
            <div class="filter-option">
                <label>الترتيب:</label>
                <form method="get" id="orderForm">
                    <select class="filter-select" name="order" onchange="document.getElementById('orderForm').submit()">
                        <option value="newest" <?= (!isset($_GET['order']) || $_GET['order'] == 'newest') ? 'selected' : '' ?>>الأحدث</option>
                        <option value="oldest" <?= (isset($_GET['order']) && $_GET['order'] == 'oldest') ? 'selected' : '' ?>>الأقدم</option>
                        <option value="name" <?= (isset($_GET['order']) && $_GET['order'] == 'name') ? 'selected' : '' ?>>الاسم (أ-ي)</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="admin-section">
        <div class="section-title">
            قائمة الأساتذة
            <span>إجمالي: <?= count($teachers) ?> أستاذ</span>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>التخصص</th>
                    <th>تاريخ الانضمام</th>
                    <th>عدد الحلقات</th>
                    <th>عدد الطلاب</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teachers as $teacher) {
                    $query = $db->prepare("SELECT id,specialization,employment_date FROM teachers WHERE user_id = ?");
                    $query->execute([$teacher['id']]);
                    $data = $query->fetchAll(PDO::FETCH_ASSOC);

                    $query = $db->prepare("SELECT * FROM groups WHERE teacher_id = ?");
                    $query->execute([$data[0]['id']]);
                    $groups = $query->fetchAll(PDO::FETCH_ASSOC);

                    $num = 0;
                    foreach ($groups as $group) {
                        $query = $db->prepare("SELECT * FROM student_groups WHERE group_id = ?");
                        $query->execute([$group['id']]);
                        $students = $query->fetchAll(PDO::FETCH_ASSOC);
                        $num += count($students);
                    }
                ?>
                    <tr>
                        <td> <?= $teacher['first_name'] . " " . $teacher['last_name'] ?></td>
                        <td><?= $data[0]['specialization'] ?></td>
                        <td><?= $data[0]['employment_date'] ?></td>
                        <td><?= count($groups) ?></td>
                        <td><?= $num ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                <a href="edit-user.php?id=<?= $teacher['id'] ?>" class="action-button edit-user">
                                    <i class="fas fa-edit"></i> تعديل
                                </a>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" style="display: inline;">
                                    <input type="text" hidden value="<?= $teacher['id'] ?>" name="delete">
                                    <button class="action-button delete" type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                        <i class="fas fa-trash"></i> حذف
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Add Teacher Modal -->
<div class="modal" id="addTeacherModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">إضافة أستاذ جديد</div>
            <button class="close-btn" id="closeAddTeacherModal">&times;</button>
        </div>
        <form class="user-form" method="post">
            <div class="form-group">
                <label class="form-label">الاسم</label>
                <input name="first_name" type="text" class="form-input <?php echo isset($errors['first_name']) ? 'error' : ''; ?>" placeholder="أدخل الاسم" required>
                <?php if (isset($errors['first_name'])): ?>
                    <span class="error-message"><?php echo $errors['first_name']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">اللقب</label>
                <input name="last_name" type="text" class="form-input <?php echo isset($errors['last_name']) ? 'error' : ''; ?>" placeholder="أدخل اللقب" required>
                <?php if (isset($errors['last_name'])): ?>
                    <span class="error-message"><?php echo $errors['last_name']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني</label>
                <input name="email" type="email" class="form-input <?php echo isset($errors['email']) ? 'error' : ''; ?>" placeholder="أدخل البريد الإلكتروني" required>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?php echo $errors['email']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <input name="password" type="password" class="form-input <?php echo isset($errors['password']) ? 'error' : ''; ?>" placeholder="أدخل كلمة المرور" required>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-message"><?php echo $errors['password']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input name="confirm_password" type="password" class="form-input <?php echo isset($errors['confirm_password']) ? 'error' : ''; ?>" placeholder="أدخل كلمة المرور" required>
                <?php if (isset($errors['confirm_password'])): ?>
                    <span class="error-message"><?php echo $errors['confirm_password']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">رقم الهاتف</label>
                <input name="phone" type="tel" class="form-input <?php echo isset($errors['phone']) ? 'error' : ''; ?>" placeholder="أدخل رقم الهاتف" pattern="[0-9]{10}" required>
                <?php if (isset($errors['phone'])): ?>
                    <span class="error-message"><?php echo $errors['phone']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">تاريخ الميلاد</label>
                <input name="date" type="date" class="form-input <?php echo isset($errors['date']) ? 'error' : ''; ?>" required>
                <?php if (isset($errors['date'])): ?>
                    <span class="error-message"><?php echo $errors['date']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">مكان الميلاد</label>
                <select name="wilaya" class="form-input <?php echo isset($errors['wilaya']) ? 'error' : ''; ?>" required>
                    <option value="">اختر الولاية</option>
                    <option value="ad-djazaïr">الجزائر</option>
                    <option value="adrar">أدرار</option>
                    <option value="ain-defla">عين الدفلى</option>
                    <option value="ain-temouchent">عين تموشنت</option>
                    <option value="alger">الجزائر</option>
                    <option value="annaba">عنابة</option>
                    <option value="bechar">بشار</option>
                    <option value="biskra">بسكرة</option>
                    <option value="bejaia">بجاية</option>
                    <option value="bordj-bouarreridj">برج بوعريريج</option>
                    <option value="bouira">البويرة</option>
                    <option value="boumerdes">بومرداس</option>
                    <option value="chlef">الشلف</option>
                    <option value="constantine">قسنطينة</option>
                    <option value="djelfa">الجلفة</option>
                    <option value="el-bayadh">البيض</option>
                    <option value="el-oued">الوادي</option>
                    <option value="el-tarf">الطارف</option>
                    <option value="ghardaia">غرداية</option>
                    <option value="guelma">قالمة</option>
                    <option value="illizi">إليزي</option>
                    <option value="khenchela">خنشلة</option>
                    <option value="laghouat">الأغواط</option>
                    <option value="msila">مسيلة</option>
                    <option value="mila">ميلة</option>
                    <option value="mostaganem">مستغانم</option>
                    <option value="naama">النعامة</option>
                    <option value="oran">وهران</option>
                    <option value="ouargla">ورقلة</option>
                    <option value="oumm-el-bouaghi">أم البواقي</option>
                    <option value="relizane">غليزان</option>
                    <option value="setif">سطيف</option>
                    <option value="saida">سعيدة</option>
                    <option value="skikda">سكيكدة</option>
                    <option value="sougueur">سوق أهراس</option>
                    <option value="sidi-bel-abbes">سيدي بلعباس</option>
                    <option value="tamanrasset">تمنراست</option>
                    <option value="tebessa">تبسة</option>
                    <option value="tlemcen">تلمسان</option>
                    <option value="tipaza">تيبازة</option>
                    <option value="tizi-ouzou">تيزي وزو</option>
                    <option value="tissemsilt">تيسمسيلت</option>
                </select>
                <?php if (isset($errors['wilaya'])): ?>
                    <span class="error-message"><?php echo $errors['wilaya']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">العنوان</label>
                <input name="address" type="text" class="form-input <?php echo isset($errors['address']) ? 'error' : ''; ?>" placeholder="أدخل عنوان السكن" required>
                <?php if (isset($errors['address'])): ?>
                    <span class="error-message"><?php echo $errors['address']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">الجنس</label>
                <select name="gender" class="form-input <?php echo isset($errors['gender']) ? 'error' : ''; ?>" required>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
                <?php if (isset($errors['gender'])): ?>
                    <span class="error-message"><?php echo $errors['gender']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">المستوى الدراسي</label>
                <input name="academic_level" type="text" class="form-input <?php echo isset($errors['academic_level']) ? 'error' : ''; ?>" placeholder="أدخل المستوى الدراسي" required>
                <?php if (isset($errors['academic_level'])): ?>
                    <span class="error-message"><?php echo $errors['academic_level']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">تاريخ بداية العمل</label>
                <input name="employment_date" type="date" class="form-input <?php echo isset($errors['employment_date']) ? 'error' : ''; ?>" required>
                <?php if (isset($errors['employment_date'])): ?>
                    <span class="error-message"><?php echo $errors['employment_date']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">التخصص</label>
                <select name="specialization" class="form-input <?php echo isset($errors['specialization']) ? 'error' : ''; ?>" required>
                    <option value="">اختر التخصص</option>
                    <option value="quran">القرآن الكريم</option>
                    <option value="hadith">الحديث الشريف</option>
                    <option value="fiqh">الفقه</option>
                    <option value="aqidah">العقيدة</option>
                </select>
                <?php if (isset($errors['specialization'])): ?>
                    <span class="error-message"><?php echo $errors['specialization']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">ملاحظات إضافية</label>
                <input name="notes" type="text" class="form-input <?php echo isset($errors['notes']) ? 'error' : ''; ?>" placeholder="ملاحظات عن الأستاذ...">
                <?php if (isset($errors['notes'])): ?>
                    <span class="error-message"><?php echo $errors['notes']; ?></span>
                <?php endif; ?>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="cancelAddTeacher">إلغاء</button>
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Functions
    const openAddTeacherModal = document.getElementById('openAddTeacherModal');
    const closeAddTeacherModal = document.getElementById('closeAddTeacherModal');
    const cancelAddTeacher = document.getElementById('cancelAddTeacher');
    const addTeacherModal = document.getElementById('addTeacherModal');

    openAddTeacherModal.addEventListener('click', function() {
        addTeacherModal.style.display = 'flex';
    });

    function closeModal() {
        addTeacherModal.style.display = 'none';
    }

    closeAddTeacherModal.addEventListener('click', closeModal);
    cancelAddTeacher.addEventListener('click', closeModal);

    window.addEventListener('click', function(event) {
        if (event.target == addTeacherModal) {
            closeModal();
        }
    });
</script>

<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 800px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        margin: 20px auto;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .close-btn {
        cursor: pointer;
        font-size: 24px;
        color: #666;
        padding: 5px;
        background: none;
        border: none;
    }

    .close-btn:hover {
        color: #333;
    }

    .user-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .form-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-input:focus {
        border-color: #4a90e2;
        outline: none;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
    }

    .form-actions {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-primary {
        background-color: #4a90e2;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }

    .form-input.error {
        border-color: #dc3545;
    }

    .form-input.error:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }
    
    .alert i {
        margin-left: 10px;
        font-size: 20px;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
</style>
</body>

</html>

<?php

if (isset($_POST['delete'])) {
    ob_start(); // بدء تخزين المخرجات
    
    $user_id = $_POST['delete'];
    $db = DBConnection::getConnection()->getDb();
    
    try {
        // أولاً، نتحقق مما إذا كان المعلم لديه مجموعات قبل محاولة حذفه
        // البحث عن معرف المعلم
        $query = $db->prepare("SELECT id FROM teachers WHERE user_id = ?");
        $query->execute([$user_id]);
        $teacher = $query->fetch(PDO::FETCH_ASSOC);
        
        if ($teacher) {
            $teacher_id = $teacher['id'];
            
            // التحقق من وجود مجموعات يشرف عليها المعلم
            $query = $db->prepare("SELECT COUNT(*) as group_count FROM groups WHERE teacher_id = ?");
            $query->execute([$teacher_id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            if ($result['group_count'] > 0) {
                // المعلم لديه مجموعات، إرسال رسالة خطأ
                ob_end_clean();
                header("Location: /quranic/admin/admin-teachers.php?has_groups=1");
                echo "<script>window.location.href = '/quranic/admin/admin-teachers.php?has_groups=1';</script>";
                exit();
            }
        }
        
        // إذا لم يكن للمعلم أي مجموعات، يمكننا المتابعة في حذفه
        require_once __DIR__ . '/admin-users.php'; // استيراد الملف الذي يحتوي على الدالة
        
        $success = deleteUserFromAllTables($db, $user_id, 'teacher');
        
        ob_end_clean(); // مسح المخرجات المخزنة
        
        if ($success) {
            header("Location: /quranic/admin/admin-teachers.php?success=1");
            echo "<script>window.location.href = '/quranic/admin/admin-teachers.php?success=1';</script>";
            exit();
        } else {
            header("Location: /quranic/admin/admin-teachers.php?error=1");
            echo "<script>window.location.href = '/quranic/admin/admin-teachers.php?error=1';</script>";
            exit();
        }
    } catch (PDOException $e) {
        ob_end_clean();
        header("Location: /quranic/admin/admin-teachers.php?error=1");
        echo "<script>window.location.href = '/quranic/admin/admin-teachers.php?error=1';</script>";
        exit();
    }
}

?>