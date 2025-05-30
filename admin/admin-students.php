<?php
$ac_student = "active";
require_once __DIR__ . '/template/header.php';

$user_type = "student";
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
$students = $query->fetchAll(PDO::FETCH_ASSOC);

// Initialize errors array
$errors = [];

if (isset($_POST))
    require_once __DIR__ . '/includes/add-student.php';
?>

<link rel="stylesheet" href="CSS/admin-students.css">

<div class="content">
    <div class="search-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="بحث عن طالب...">
        </div>
        <button class="add-btn" id="openAddStudentModal">
            <i class="fas fa-plus"></i> إضافة طالب جديد
        </button>
    </div>

    <div class="stats-cards">
        <div class="stat-card">
            <div class="number blue"><?= count($students) ?></div>
            <div class="label">إجمالي الطلاب</div>
        </div>
        <div class="stat-card">
            <div class="number green">87</div>
            <div class="label">طلاب جدد هذا الشهر</div>
        </div>
        <div class="stat-card">
            <div class="number orange">95%</div>
            <div class="label">نسبة الحضور</div>
        </div>
    </div>

    <div class="filter-section">
        <div class="filter-title">تصفية النتائج</div>
        <div class="filter-options">
            <div class="filter-option">
                <label>الحلقة:</label>
                <select class="filter-select">
                    <option value="all">الكل</option>
                    <option value="1">حلقة القرآن 1</option>
                    <option value="2">حلقة القرآن 2</option>
                    <option value="3">حلقة الحديث 1</option>
                    <option value="4">حلقة الفقه 1</option>
                </select>
            </div>
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
            قائمة الطلاب
            <span>إجمالي: <?= count($students) ?> طالب</span>
        </div>

        <div class="tabs">
            <div class="tab active">جميع الطلاب</div>
            <div class="tab">طلاب تم تسجيلهم</div>
            <div class="tab">طلاب غير مسجلين</div>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>اسم الطالب</th>
                    <th>الحلقة</th>
                    <th>المستوى</th>
                    <th>تاريخ الانضمام</th>
                    <th>نسبة التقدم</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) {
                    $query = $db->prepare("SELECT * FROM students WHERE user_id = ?");
                    $query->execute([$student['id']]);
                    $data = $query->fetchAll(PDO::FETCH_ASSOC);

                    $query = $db->prepare("SELECT group_id FROM student_groups WHERE id = ?");
                    $query->execute([$student['id']]);
                    $group_id = $query->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($group_id)) {
                        $query = $db->prepare("SELECT * FROM groups WHERE id = ?");
                        $query->execute([$group_id[0]['group_id']]);
                        $group = $query->fetchAll(PDO::FETCH_ASSOC);
                    }
                    $bgColor = match ($data[0]['registered']) {
                        1 => 'status-active',
                        0 => 'status-inactive'
                    };
                ?>
                    <tr>
                        <td><?= $student['first_name'] . " " . $student['last_name'] ?></td>
                        <td><?= $group[0]['group_name'] ?? "" ?></td>
                        <td><?= $data[0]['enrollment_date'] ?></td>
                        <td><span class="status <?= $bgColor ?>"><?= $data[0]['registered'] == 1 ? "مسجل" : "غير مسجل" ?></span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<!-- Add Student Modal -->
<div class="modal" id="addStudentModal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">إضافة طالب جديد</div>
            <button class="close-btn" id="closeAddStudentModal">&times;</button>
        </div>
        <form class="user-form" id="userForm" method="post">
                <div class="form-group">
                    <label class="form-label">الاسم </label>
                    <input name="first_name" type="text" class="form-control" placeholder="أدخل الاسم ">
                    <span class="error"><?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label"> اللقب</label>
                    <input name="last_name" type="text" class="form-control" placeholder="أدخل اللقب">
                    <span class="error"><?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input name="email" type="email" class="form-control" placeholder="أدخل البريد الإلكتروني">
                    <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <input name="password" type="password" class="form-control" placeholder="أدخل كلمة المرور">
                    <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label"> تأكيد كلمة المرور</label>
                    <input name="confirm_password" type="password" class="form-control" placeholder="أدخل كلمة المرور">
                    <span class="error"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input name="phone" type="tel" class="form-control" placeholder="أدخل رقم الهاتف" pattern="[0-9]{10}">
                    <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">تاريخ الميلاد </label>
                    <input name="date" type="date" class="form-control" placeholder="أدخل تاريخ الميلاد">
                    <span class="error"><?php echo isset($errors['date']) ? $errors['date'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="wilaya" class="form-label">مكان الميلاد</label>
                    <select name="wilaya" id="wilaya" class="form-control">
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
                    <span class="error"><?php echo isset($errors['wilaya']) ? $errors['wilaya'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">العنوان </label>
                    <input name="address" type="text" class="form-control" placeholder="أدخل عنوان السكن">
                    <span class="error"><?php echo isset($errors['address']) ? $errors['address'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">الجنس</label>
                    <select name="gender" class="form-control">
                        <option value="male">ذكر</option>
                        <option value="female">أنثى</option>
                    </select>
                    <span class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>
                </div>
                <div class="form-group">
                    <label class="form-label">المستوى الدراسي </label>
                    <input name="academic_level" type="text" class="form-control" placeholder="أدخل المستوى الدراسي">
                    <span class="error"><?php echo isset($errors['academic_level']) ? $errors['academic_level'] : ''; ?></span>
                </div>
                <div class="form-group student-field" >
                    <label class="form-label">مسجل :</label>
                    <input id="yes" value="1" name="regestred" type="radio" checked>
                    <label for="yes">نعم</label>
                    <input id="no" value="0" name="regestred" type="radio">
                    <label for="no">لا</label>
                    <span class="error"><?php echo isset($errors['regestred']) ? $errors['regestred'] : ''; ?></span>
                </div>
                <div class="form-group student-field">
                    <label class="form-label">الاسم الكامل لولي الامر</label>
                    <input name="parent_name" type="text" class="form-control" placeholder="ادخل اسم الولي">
                    <span class="error"><?php echo isset($errors['parent_name']) ? $errors['parent_name'] : ''; ?></span>
                </div>
                <div class="form-group full-width">
                    <label class="form-label">ملاحظات اضافية </label>
                    <input name="notes" type="text" class="form-control" placeholder="ملاحظات عن المستخدم ...">
                    <span class="error"><?php echo isset($errors['notes']) ? $errors['notes'] : ''; ?></span>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelUserBtn">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Modal Functions
    const openAddStudentModal = document.getElementById('openAddStudentModal');
    const closeAddStudentModal = document.getElementById('closeAddStudentModal');
    const addStudentModal = document.getElementById('addStudentModal');

    openAddStudentModal.addEventListener('click', function() {
        addStudentModal.style.display = 'flex';
    });

    closeAddStudentModal.addEventListener('click', function() {
        addStudentModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target == addStudentModal) {
            addStudentModal.style.display = 'none';
        }
    });
</script>
</body>


<style>
    .form-group {
    margin-bottom: 15px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 14px;
}

.form-group.full-width {
    grid-column: 1 / -1;
    
}

.form-actions {
    grid-column: 1 / -1;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 15px;
}

.btn {
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
}

.btn-primary {
    background-color: #00A841;
    color: white;
}

.btn-secondary {
    background-color: #f5f5f5;
    color: #333;
}
</style>
<style>
.error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    display: block;
}

.form-group {
    margin-bottom: 1rem;
    position: relative;
}

.form-control.error {
    border-color: #dc3545;
}

.form-control.error:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.user-form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.alert {
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 15px;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 992px) {
    .user-form {
        grid-template-columns: 1fr !important;
    }
}

/* إضافات CSS خاصة بصفحة تعديل المستخدم */

.user-form {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    column-gap: 10px;
}

.user-form .form-group input[type="radio"] {
    width: auto;
    margin-right: 8px;
    margin-left: 15px;
}

.user-form .form-group label[for="yes"],
.user-form .form-group label[for="no"] {
    font-weight: normal;
    margin-bottom: 0;
    cursor: pointer;
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.section-title {
    border-bottom: 2px solid #00A841;
    padding-bottom: 10px;
    margin-bottom: 25px;
}

.form-actions {
    padding-top: 20px;
    border-top: 1px solid #eee;
    margin-top: 20px;
}

.btn {
    min-width: 120px;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

/* تحسين الاستجابة للشاشات الصغيرة */
@media (max-width: 768px) {
    .user-form {
        padding: 15px;
    }
    
    .section-title {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
</html>