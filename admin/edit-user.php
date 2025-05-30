<?php
$ac_user = "active";
require_once __DIR__ . '/template/header.php';

// التحقق من وجود معرف المستخدم
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin-users.php");
    exit();
}

$user_id = $_GET['id'];

// جلب بيانات المستخدم الحالية
try {
    $query = $db->prepare("SELECT * FROM users WHERE id = ?");
    $query->execute([$user_id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        header("Location: admin-users.php?error=user_not_found");
        exit();
    }
    
    // جلب البيانات الإضافية حسب نوع المستخدم
    $additional_data = [];
    if ($user['user_type'] == 'student') {
        $query = $db->prepare("SELECT * FROM students WHERE user_id = ?");
        $query->execute([$user_id]);
        $additional_data = $query->fetch(PDO::FETCH_ASSOC);
    } elseif ($user['user_type'] == 'teacher') {
        $query = $db->prepare("SELECT * FROM teachers WHERE user_id = ?");
        $query->execute([$user_id]);
        $additional_data = $query->fetch(PDO::FETCH_ASSOC);
    } elseif ($user['user_type'] == 'supervisor') {
        $query = $db->prepare("SELECT * FROM supervisors WHERE user_id = ?");
        $query->execute([$user_id]);
        $additional_data = $query->fetch(PDO::FETCH_ASSOC);
    }
    
} catch (PDOException $e) {
    header("Location: admin-users.php?error=database_error");
    exit();
}

// معالجة تحديث البيانات
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    
    // التحقق من البيانات
    if (empty($_POST['first_name'])) {
        $errors['first_name'] = 'الاسم مطلوب';
    }
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = 'اللقب مطلوب';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'البريد الإلكتروني مطلوب';
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'البريد الإلكتروني غير صحيح';
    }
    
    // التحقق من عدم تكرار البريد الإلكتروني (باستثناء المستخدم الحالي)
    $email_check = $db->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $email_check->execute([$_POST['email'], $user_id]);
    if ($email_check->fetch()) {
        $errors['email'] = 'البريد الإلكتروني مستخدم مسبقاً';
    }
    
    if (empty($errors)) {
        try {
            // تحديث بيانات المستخدم الأساسية
            $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ?, date_of_birth = ?, place_of_birth = ?, address = ?, gender = ?, academic_level = ?";
            $params = [
                $_POST['first_name'],
                $_POST['last_name'],
                $_POST['email'],
                $_POST['phone'],
                $_POST['date'],
                $_POST['wilaya'],
                $_POST['address'],
                $_POST['gender'],
                $_POST['academic_level']
            ];
            
            // تحديث كلمة المرور إذا تم إدخالها
            if (!empty($_POST['password'])) {
                if ($_POST['password'] !== $_POST['confirm_password']) {
                    $errors['confirm_password'] = 'كلمة المرور غير متطابقة';
                } else {
                    $update_query .= ", password = ?";
                    $params[] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                }
            }
            
            $update_query .= " WHERE id = ?";
            $params[] = $user_id;
            
            if (empty($errors)) {
                $query = $db->prepare($update_query);
                $query->execute($params);
                
                // تحديث البيانات الإضافية حسب نوع المستخدم
                if ($user['user_type'] == 'student') {
                    $student_query = "UPDATE students SET registered = ?, parent_name = ? , notes = ? WHERE user_id = ?";
                    $student_params = [
                        $_POST['regestred'] ?? 1,
                        $_POST['parent_name'],
                        $_POST['notes'],
                        $user_id
                    ];
                    $query = $db->prepare($student_query);
                    $query->execute($student_params);
                } elseif ($user['user_type'] == 'teacher') {
                    $teacher_query = "UPDATE teachers SET employment_date = ? WHERE user_id = ?";
                    $teacher_params = [
                        $_POST['employment_date'],
                        $user_id
                    ];
                    $query = $db->prepare($teacher_query);
                    $query->execute($teacher_params);
                } elseif ($user['user_type'] == 'supervisor') {
                    $supervisor_query = "UPDATE supervisors SET employment_date = ?, position = ? WHERE user_id = ?";
                    $supervisor_params = [
                        $_POST['employment_date'],
                        $_POST['position'],
                        $user_id
                    ];
                    $query = $db->prepare($supervisor_query);
                    $query->execute($supervisor_params);
                }
                
                header("Location: admin-users.php?success=user_updated");
                exit();
            }
            
        } catch (PDOException $e) {
            $errors['general'] = 'حدث خطأ أثناء تحديث البيانات';
        }
    }
}
?>

<link rel="stylesheet" href="CSS/admin-users.css">

<div class="content">
    <div class="admin-section">
        <div class="section-title">
            تعديل بيانات المستخدم: <?= $user['first_name'] . ' ' . $user['last_name'] ?>
            <a href="admin-users.php" class="btn btn-secondary" style="font-size: 14px; padding: 8px 15px;">عودة للقائمة</a>
        </div>

        <?php if (isset($errors['general'])): ?>
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <?= $errors['general'] ?>
            </div>
        <?php endif; ?>

        <form class="user-form" method="post" style="display: grid; grid-template-columns: 1fr 1fr; column-gap: 15px;">
            <div class="form-group full-width">
                <label class="form-label">نوع المستخدم</label>
                <input type="text" class="form-control" value="<?= ucfirst($user['user_type']) ?>" readonly style="background-color: #f8f9fa;">
            </div>

            <div class="form-group">
                <label class="form-label">الاسم</label>
                <input name="first_name" type="text" class="form-control" placeholder="أدخل الاسم" value="<?= htmlspecialchars($user['first_name']) ?>">
                <span class="error"><?php echo isset($errors['first_name']) ? $errors['first_name'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">اللقب</label>
                <input name="last_name" type="text" class="form-control" placeholder="أدخل اللقب" value="<?= htmlspecialchars($user['last_name']) ?>">
                <span class="error"><?php echo isset($errors['last_name']) ? $errors['last_name'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">البريد الإلكتروني</label>
                <input name="email" type="email" class="form-control" placeholder="أدخل البريد الإلكتروني" value="<?= htmlspecialchars($user['email']) ?>">
                <span class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">كلمة المرور الجديدة (اتركها فارغة للاحتفاظ بالحالية)</label>
                <input name="password" type="password" class="form-control" placeholder="أدخل كلمة المرور الجديدة">
                <span class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input name="confirm_password" type="password" class="form-control" placeholder="أدخل كلمة المرور مرة أخرى">
                <span class="error"><?php echo isset($errors['confirm_password']) ? $errors['confirm_password'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">رقم الهاتف</label>
                <input name="phone" type="tel" class="form-control" placeholder="أدخل رقم الهاتف" pattern="[0-9]{10}" value="<?= htmlspecialchars($user['phone']) ?>">
                <span class="error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">تاريخ الميلاد</label>
                <input name="date" type="date" class="form-control" value="<?= $user['date_of_birth'] ?>">
                <span class="error"><?php echo isset($errors['date']) ? $errors['date'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label for="wilaya" class="form-label">مكان الميلاد</label>
                <select name="wilaya" id="wilaya" class="form-control">
                    <option value="">اختر الولاية</option>
                    <option value="ad-djazaïr" <?= $user['wilaya'] == 'ad-djazaïr' ? 'selected' : '' ?>>الجزائر</option>
                    <option value="adrar" <?= $user['wilaya'] == 'adrar' ? 'selected' : '' ?>>أدرار</option>
                    <option value="ain-defla" <?= $user['wilaya'] == 'ain-defla' ? 'selected' : '' ?>>عين الدفلى</option>
                    <option value="ain-temouchent" <?= $user['wilaya'] == 'ain-temouchent' ? 'selected' : '' ?>>عين تموشنت</option>
                    <option value="alger" <?= $user['wilaya'] == 'alger' ? 'selected' : '' ?>>الجزائر</option>
                    <option value="annaba" <?= $user['wilaya'] == 'annaba' ? 'selected' : '' ?>>عنابة</option>
                    <option value="bechar" <?= $user['wilaya'] == 'bechar' ? 'selected' : '' ?>>بشار</option>
                    <option value="biskra" <?= $user['wilaya'] == 'biskra' ? 'selected' : '' ?>>بسكرة</option>
                    <option value="bejaia" <?= $user['wilaya'] == 'bejaia' ? 'selected' : '' ?>>بجاية</option>
                    <option value="bordj-bouarreridj" <?= $user['wilaya'] == 'bordj-bouarreridj' ? 'selected' : '' ?>>برج بوعريريج</option>
                    <option value="bouira" <?= $user['wilaya'] == 'bouira' ? 'selected' : '' ?>>البويرة</option>
                    <option value="boumerdes" <?= $user['wilaya'] == 'boumerdes' ? 'selected' : '' ?>>بومرداس</option>
                    <option value="chlef" <?= $user['wilaya'] == 'chlef' ? 'selected' : '' ?>>الشلف</option>
                    <option value="constantine" <?= $user['wilaya'] == 'constantine' ? 'selected' : '' ?>>قسنطينة</option>
                    <option value="djelfa" <?= $user['wilaya'] == 'djelfa' ? 'selected' : '' ?>>الجلفة</option>
                    <option value="el-bayadh" <?= $user['wilaya'] == 'el-bayadh' ? 'selected' : '' ?>>البيض</option>
                    <option value="el-oued" <?= $user['wilaya'] == 'el-oued' ? 'selected' : '' ?>>الوادي</option>
                    <option value="el-tarf" <?= $user['wilaya'] == 'el-tarf' ? 'selected' : '' ?>>الطارف</option>
                    <option value="ghardaia" <?= $user['wilaya'] == 'ghardaia' ? 'selected' : '' ?>>غرداية</option>
                    <option value="guelma" <?= $user['wilaya'] == 'guelma' ? 'selected' : '' ?>>قالمة</option>
                    <option value="illizi" <?= $user['wilaya'] == 'illizi' ? 'selected' : '' ?>>إليزي</option>
                    <option value="khenchela" <?= $user['wilaya'] == 'khenchela' ? 'selected' : '' ?>>خنشلة</option>
                    <option value="laghouat" <?= $user['wilaya'] == 'laghouat' ? 'selected' : '' ?>>الأغواط</option>
                    <option value="msila" <?= $user['wilaya'] == 'msila' ? 'selected' : '' ?>>مسيلة</option>
                    <option value="mila" <?= $user['wilaya'] == 'mila' ? 'selected' : '' ?>>ميلة</option>
                    <option value="mostaganem" <?= $user['wilaya'] == 'mostaganem' ? 'selected' : '' ?>>مستغانم</option>
                    <option value="naama" <?= $user['wilaya'] == 'naama' ? 'selected' : '' ?>>النعامة</option>
                    <option value="oran" <?= $user['wilaya'] == 'oran' ? 'selected' : '' ?>>وهران</option>
                    <option value="ouargla" <?= $user['wilaya'] == 'ouargla' ? 'selected' : '' ?>>ورقلة</option>
                    <option value="oumm-el-bouaghi" <?= $user['wilaya'] == 'oumm-el-bouaghi' ? 'selected' : '' ?>>أم البواقي</option>
                    <option value="relizane" <?= $user['wilaya'] == 'relizane' ? 'selected' : '' ?>>غليزان</option>
                    <option value="setif" <?= $user['wilaya'] == 'setif' ? 'selected' : '' ?>>سطيف</option>
                    <option value="saida" <?= $user['wilaya'] == 'saida' ? 'selected' : '' ?>>سعيدة</option>
                    <option value="skikda" <?= $user['wilaya'] == 'skikda' ? 'selected' : '' ?>>سكيكدة</option>
                    <option value="sougueur" <?= $user['wilaya'] == 'sougueur' ? 'selected' : '' ?>>سوق أهراس</option>
                    <option value="sidi-bel-abbes" <?= $user['wilaya'] == 'sidi-bel-abbes' ? 'selected' : '' ?>>سيدي بلعباس</option>
                    <option value="tamanrasset" <?= $user['wilaya'] == 'tamanrasset' ? 'selected' : '' ?>>تمنراست</option>
                    <option value="tebessa" <?= $user['wilaya'] == 'tebessa' ? 'selected' : '' ?>>تبسة</option>
                    <option value="tlemcen" <?= $user['wilaya'] == 'tlemcen' ? 'selected' : '' ?>>تلمسان</option>
                    <option value="tipaza" <?= $user['wilaya'] == 'tipaza' ? 'selected' : '' ?>>تيبازة</option>
                    <option value="tizi-ouzou" <?= $user['wilaya'] == 'tizi-ouzou' ? 'selected' : '' ?>>تيزي وزو</option>
                    <option value="tissemsilt" <?= $user['wilaya'] == 'tissemsilt' ? 'selected' : '' ?>>تيسمسيلت</option>
                </select>
                <span class="error"><?php echo isset($errors['wilaya']) ? $errors['wilaya'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">العنوان</label>
                <input name="address" type="text" class="form-control" placeholder="أدخل عنوان السكن" value="<?= htmlspecialchars($user['address']) ?>">
                <span class="error"><?php echo isset($errors['address']) ? $errors['address'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">الجنس</label>
                <select name="gender" class="form-control">
                    <option value="male" <?= $user['gender'] == 'male' ? 'selected' : '' ?>>ذكر</option>
                    <option value="female" <?= $user['gender'] == 'female' ? 'selected' : '' ?>>أنثى</option>
                </select>
                <span class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>
            </div>

            <div class="form-group">
                <label class="form-label">المستوى الدراسي</label>
                <input name="academic_level" type="text" class="form-control" placeholder="أدخل المستوى الدراسي" value="<?= htmlspecialchars($user['academic_level']) ?>">
                <span class="error"><?php echo isset($errors['academic_level']) ? $errors['academic_level'] : ''; ?></span>
            </div>

            <!-- حقول خاصة بالأساتذة والمشرفين -->
            <?php if ($user['user_type'] == 'teacher' || $user['user_type'] == 'supervisor'): ?>
                <div class="form-group">
                    <label class="form-label">تاريخ بداية العمل</label>
                    <input name="employment_date" type="date" class="form-control" value="<?= $additional_data['employment_date'] ?? '' ?>">
                    <span class="error"><?php echo isset($errors['employment_date']) ? $errors['employment_date'] : ''; ?></span>
                </div>
            <?php endif; ?>

            <!-- حقول خاصة بالمشرفين -->
            <?php if ($user['user_type'] == 'supervisor'): ?>
                <div class="form-group">
                    <label class="form-label">الوظيفة</label>
                    <input name="position" type="text" class="form-control" placeholder="ادخل الوظيفة" value="<?= htmlspecialchars($additional_data['position'] ?? '') ?>">
                    <span class="error"><?php echo isset($errors['position']) ? $errors['position'] : ''; ?></span>
                </div>
            <?php endif; ?>

            <!-- حقول خاصة بالطلاب -->
            <?php if ($user['user_type'] == 'student'): ?>

                <div class="form-group">
                    <label class="form-label">الاسم الكامل لولي الامر</label>
                    <input name="parent_name" type="text" class="form-control" placeholder="ادخل اسم الولي" value="<?= htmlspecialchars($additional_data['parent_name'] ?? '') ?>">
                    <span class="error"><?php echo isset($errors['parent_name']) ? $errors['parent_name'] : ''; ?></span>
                </div>
            <?php endif; ?>

            <div class="form-group full-width">
                <label class="form-label">ملاحظات اضافية</label>
                <textarea name="notes" class="form-control" placeholder="ملاحظات عن المستخدم ..." rows="3"><?= isset($additional_data['notes']) ? htmlspecialchars($additional_data['notes']) : "" ?></textarea>
                <span class="error"><?php echo isset($errors['notes']) ? $errors['notes'] : ''; ?></span>
            </div>

            <div class="form-actions">
                <a href="admin-users.php" class="btn btn-secondary">إلغاء</a>
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </form>
    </div>
</div>
</div>

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

</body>
</html>