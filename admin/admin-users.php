<?php
$active = "active";
require_once __DIR__ . '/template/header.php';

if(isset($_POST['user_type']) && $_POST['user_type'] == "student")
    require_once __DIR__ .'/includes/add-student.php';

//print_r($_POST);

if (!empty($_GET)) {
    $userType = $_GET['user_type'];
    $query = $db->prepare("SELECT * FROM users WHERE user_type=?");
    $query->execute([$userType]);
} else {
    $query = $db->query("SELECT * FROM users");
    $query->execute();
}
$users = $query->fetchAll(PDO::FETCH_ASSOC);



?>

<link rel="stylesheet" href="CSS/admin-users.css">

<div class="content">
    <div class="search-bar">
        <div class="search-input">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="بحث عن مستخدم...">
        </div>
        <button class="add-btn" id="addUserBtn">
            <i class="fas fa-plus"></i> إضافة مستخدم جديد
        </button>
    </div>

    <div class="admin-section">
        <div class="section-title">
            إدارة المستخدمين
        </div>

        <div class="filter-bar">
            <a class="filter-item <?= empty($_GET['user_type']) ? "active" : "" ?>" href="admin-users.php">الكل</a>
            <a class="filter-item <?= (isset($_GET['user_type']) && $_GET['user_type'] === 'admin') ? "active" : "" ?>" href="?user_type=admin">مشرفين</a>
            <a class="filter-item <?= (isset($_GET['user_type']) && $_GET['user_type'] === 'teacher') ? "active" : "" ?>" href="?user_type=teacher">أساتذة</a>
            <a class="filter-item <?= (isset($_GET['user_type']) && $_GET['user_type'] === 'student') ? "active" : "" ?>" href="?user_type=student">طلاب</a>
        </div>


        <table class="admin-table">
            <thead>
                <tr>
                    <th>اسم المستخدم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الدور</th>
                    <th>تاريخ التسجيل</th>
                    <th>رقم الهاتف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['first_name'] . " " . $user['last_name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['user_type'] ?></td>
                        <td><?= date("Y-m-d", strtotime($user['created_at'])) ?></td>
                        <td><span class="status status-active"><?= $user['phone'] ?></span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-button edit-user"><i class="fas fa-edit"></i> تعديل</button>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                                    <input type="text" hidden value="<?= $user['id'] ?>" name="user_id">
                                    <input type="text" hidden value="<?= $user['user_type'] ?>" name="delete_type">
                                    <button class="action-button delete" type="submit"><i class="fas fa-trash"></i> حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!--            <div class="pagination">-->
        <!--                <div class="page-item"><i class="fas fa-chevron-right"></i></div>-->
        <!--                <div class="page-item active">1</div>-->
        <!--                <div class="page-item">2</div>-->
        <!--                <div class="page-item">3</div>-->
        <!--                <div class="page-item"><i class="fas fa-chevron-left"></i></div>-->
        <!--            </div>-->
    </div>
</div>
</div>

<!-- User Add/Edit Modal -->
<div class="modal-overlay" id="userModal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-title">إضافة مستخدم جديد</div>
            <div class="modal-close">&times;</div>
        </div>
        <form class="user-form" id="userForm" method="post">
            <div class="form-group full-width">
                <label class="form-label">نوع المستخدم</label>
                <select name="user_type" class="form-control" id="userTypeSelect">
                    <option value="">-- اختر نوع المستخدم --</option>
                    <option value="student">طالب</option>
                    <option value="supervisor">مشرف</option>
                    <option value="teacher">أستاذ</option>
                </select>
                <span class="error"><?php echo isset($errors['user_type']) ? $errors['user_type'] : ''; ?></span>
            </div>

            <div id="extraFields" style="
                display: none;
                grid-template-columns: 1fr 1fr;
                column-gap: 15px;
                ">
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
                <div class="form-group teacher-field supervisor-field">
                    <label class="form-label">تاريخ بداية العمل </label>
                    <input name="employment_date" type="date" class="form-control" >
                    <span class="error"><?php echo isset($errors['employment_date']) ? $errors['employment_date'] : ''; ?></span>
                </div>
                <div class="form-group supervisor-field">
                    <label class="form-label">الوظيفة </label>
                    <input name="position" type="text" class="form-control" placeholder="ادخل الوظيفة">
                    <span class="error"><?php echo isset($errors['position']) ? $errors['position'] : ''; ?></span>
                </div>
                <div class="form-group student-field" style="display: none;">
                    <label class="form-label">مسجل :</label>
                    <input id="yes" value="1" name="regestred" type="radio" checked>
                    <label for="yes">نعم</label>
                    <input id="no" value="0" name="regestred" type="radio">
                    <label for="no">لا</label>
                    <span class="error"><?php echo isset($errors['regestred']) ? $errors['regestred'] : ''; ?></span>
                </div>
                <div class="form-group student-field" style="display: none;">
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
 userTypeSelect.addEventListener('change', () => {
    const userType = userTypeSelect.value;

    // إظهار الحقول العامة
    extraFields.style.display = userType !== "" ? 'grid' : 'none';

    // إخفاء الحقول الخاصة أولًا
    document.querySelectorAll('.student-field').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.teacher-field').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.supervisor-field').forEach(el => el.style.display = 'none');

    // إظهار الحقول الخاصة بالنوع المختار
    if (userType === 'student') {
        document.querySelectorAll('.student-field').forEach(el => el.style.display = 'block');
    } else if (userType === 'teacher') {
        document.querySelectorAll('.teacher-field').forEach(el => el.style.display = 'block');
    } else if (userType === 'supervisor') {
        document.querySelectorAll('.supervisor-field').forEach(el => el.style.display = 'block');
    }
});


</script>
<script>
    // Show/Hide Modal
    const modal = document.getElementById('userModal');
    const addUserBtn = document.getElementById('addUserBtn');
    const cancelUserBtn = document.getElementById('cancelUserBtn');
    const modalClose = document.querySelector('.modal-close');
    const editButtons = document.querySelectorAll('.edit-user');

    addUserBtn.addEventListener('click', function() {
        modal.style.display = 'flex';
        document.querySelector('.modal-title').textContent = 'إضافة مستخدم جديد';
    });

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            modal.style.display = 'flex';
            document.querySelector('.modal-title').textContent = 'تعديل بيانات المستخدم';
        });
    });

    function closeModal() {
        modal.style.display = 'none';
    }

    cancelUserBtn.addEventListener('click', closeModal);
    modalClose.addEventListener('click', closeModal);

    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Filter Items
    const filterItems = document.querySelectorAll('.filter-item');

    filterItems.forEach(item => {
        item.addEventListener('click', function() {
            filterItems.forEach(fi => fi.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>

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
</style>
</body>

</html>

<?php

if(isset($_POST['user_id']) && $_POST['delete_type'] == "student") {
    ob_start(); // Start output buffering
    
    $user_id = $_POST['user_id'];
    $db = DBConnection::getConnection()->getDb();
    
    try {
        $query = $db->prepare("DELETE FROM students WHERE user_id=?");
        $query->execute([$user_id]);

        $query = $db->prepare("DELETE FROM users WHERE id=?");
        $query->execute([$user_id]);

        ob_end_clean(); // Clear any output
        header("Location: /quranic/admin/admin-users.php?user_type=student");
        echo "<script>window.location.href = '/quranic/admin/admin-users.php?user_type=student';</script>";
        exit();
    } catch (PDOException $e) {
        ob_end_clean();
        header("Location: /quranic/admin/admin-users.php?user_type=student&error=1");
        echo "<script>window.location.href = '/quranic/admin/admin-users.php?user_type=student&error=1';</script>";
        exit();
    }
}
 ?>