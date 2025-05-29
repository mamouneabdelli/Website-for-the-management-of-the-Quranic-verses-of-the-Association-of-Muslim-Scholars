<?php
$ac_student = "active";
require_once __DIR__ .'/template/header.php';

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
                    <div class="number blue">523</div>
                    <div class="label">إجمالي الطلاب</div>
                </div>
                <div class="stat-card">
                    <div class="number green">87</div>
                    <div class="label">طلاب جدد هذا الشهر</div>
                </div>
                <div class="stat-card">
                    <div class="number red">45</div>
                    <div class="label">طلاب أكملوا المستوى</div>
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
                        <label>المستوى:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="beginner">مبتدئ</option>
                            <option value="intermediate">متوسط</option>
                            <option value="advanced">متقدم</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>الحالة:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="active">نشط</option>
                            <option value="inactive">غير نشط</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>الترتيب:</label>
                        <select class="filter-select">
                            <option value="newest">الأحدث</option>
                            <option value="oldest">الأقدم</option>
                            <option value="name">الاسم (أ-ي)</option>
                            <option value="progress">التقدم</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-title">
                    قائمة الطلاب
                    <span>إجمالي: 523 طالب</span>
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
                        <tr>
                            <td>محمد عبد الله</td>
                            <td>حلقة القرآن 1</td>
                            <td>متقدم</td>
                            <td>15 مارس 2025</td>
                            <td>
                                <div>85%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 85%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-active">نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>أحمد محمود</td>
                            <td>حلقة القرآن 2</td>
                            <td>متوسط</td>
                            <td>20 مارس 2025</td>
                            <td>
                                <div>65%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 65%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-active">نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>عبد الرحمن سعيد</td>
                            <td>حلقة الحديث 1</td>
                            <td>مبتدئ</td>
                            <td>1 أبريل 2025</td>
                            <td>
                                <div>25%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 25%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-active">نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>خالد محمد</td>
                            <td>حلقة الفقه 1</td>
                            <td>متقدم</td>
                            <td>5 مارس 2025</td>
                            <td>
                                <div>95%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 95%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-active">نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>عبد الله أحمد</td>
                            <td>حلقة القرآن 1</td>
                            <td>متوسط</td>
                            <td>10 مارس 2025</td>
                            <td>
                                <div>50%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 50%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-inactive">غير نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>رامي عبد الرحمن</td>
                            <td>حلقة القرآن 2</td>
                            <td>مبتدئ</td>
                            <td>2 أبريل 2025</td>
                            <td>
                                <div>15%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 15%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-active">نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>سليمان محمود</td>
                            <td>حلقة الحديث 1</td>
                            <td>متقدم</td>
                            <td>15 فبراير 2025</td>
                            <td>
                                <div>90%</div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 90%;"></div>
                                </div>
                            </td>
                            <td><span class="status status-active">نشط</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination">
                    <div class="page-item"><i class="fas fa-angle-double-right"></i></div>
                    <div class="page-item active">1</div>
                    <div class="page-item">2</div>
                    <div class="page-item">3</div>
                    <div class="page-item">4</div>
                    <div class="page-item"><i class="fas fa-angle-double-left"></i></div>
                </div>
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
            <form>
                <div class="form-group">
                    <label class="form-label">اسم الطالب</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="tel" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">تاريخ الميلاد</label>
                    <input type="date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">الحلقة</label>
                    <select class="form-input" required>
                        <option value="">اختر الحلقة</option>
                        <option value="1">حلقة القرآن 1</option>
                        <option value="2">حلقة القرآن 2</option>
                        <option value="3">حلقة الحديث 1</option>
                        <option value="4">حلقة الفقه 1</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">المستوى</label>
                    <select class="form-input" required>
                        <option value="beginner">مبتدئ</option>
                        <option value="intermediate">متوسط</option>
                        <option value="advanced">متقدم</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">ولي الأمر</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">رقم هاتف ولي الأمر</label>
                    <input type="tel" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">ملاحظات</label>
                    <input type="text" class="form-input">
                </div>
                <button type="submit" class="form-submit">إضافة الطالب</button>
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
</html>