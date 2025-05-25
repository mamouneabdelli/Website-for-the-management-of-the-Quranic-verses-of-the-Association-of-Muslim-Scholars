<?php
$active = "active";
require_once __DIR__ . '/template/header.php';
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
                                <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
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
        <form class="user-form">
            <div class="form-group full-width">
                <label class="form-label">نوع المستخدم</label>
                <select name="user_type" class="form-control" onchange="this.form.submit()">
                    <option value="student">طالب</option>
                    <option value="supervisor">مشرف</option>
                    <option value="teacher" >أستاد</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">الاسم </label>
                <input name="first_name" type="text" class="form-control" placeholder="أدخل الاسم ">
            </div>
            <div class="form-group">
                <label class="form-label"> اللقب</label>
                <input name="last_name" type="text" class="form-control" placeholder="أدخل اللقب">
            </div>
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني</label>
                <input name="email" type="email" class="form-control" placeholder="أدخل البريد الإلكتروني">
            </div>
            <div class="form-group">
                <label class="form-label">البريد الإلكتروني</label>
                <input name="phone" type="text" class="form-control" placeholder="أدخل البريد الإلكتروني">
            </div>
            <div class="form-group">
                <label class="form-label">كلمة المرور</label>
                <input name="password" type="password" class="form-control" placeholder="أدخل كلمة المرور">
            </div>
            <div class="form-group">
                <label class="form-label"> تأكيد كلمة المرور</label>
                <input name="confirm_password" type="password" class="form-control" placeholder="أدخل كلمة المرور">
            </div>
            <div class="form-group">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" class="form-control" placeholder="أدخل رقم الهاتف">
            </div>
            <div class="form-group">
                <label class="form-label">الجنس</label>
                <select class="form-control">
                    <option>دكر</option>
                    <option>أنثى</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" id="cancelUserBtn">إلغاء</button>
                <button type="button" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
</div>

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
</body>

</html>