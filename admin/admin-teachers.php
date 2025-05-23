<?php

require_once __DIR__ .'/template/header.php';

?>

<link rel="stylesheet" href="CSS/admin-teachers.css">

        <div class="content">
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
                        <label>الحالة:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="active">نشط</option>
                            <option value="pending">قيد المراجعة</option>
                            <option value="inactive">غير نشط</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>التخصص:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="quran">القرآن الكريم</option>
                            <option value="hadith">الحديث الشريف</option>
                            <option value="fiqh">الفقه</option>
                            <option value="aqidah">العقيدة</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>الترتيب:</label>
                        <select class="filter-select">
                            <option value="newest">الأحدث</option>
                            <option value="oldest">الأقدم</option>
                            <option value="name">الاسم (أ-ي)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-title">
                    قائمة الأساتذة
                    <span>إجمالي: 40 أستاذ</span>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>التخصص</th>
                            <th>تاريخ الانضمام</th>
                            <th>عدد الحلقات</th>
                            <th>عدد الطلاب</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>محمد علي أحمد</td>
                            <td>القرآن الكريم</td>
                            <td>10 أبريل 2025</td>
                            <td>3</td>
                            <td>45</td>
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
                            <td>خالد محمود عبد الرحمن</td>
                            <td>الفقه</td>
                            <td>5 أبريل 2025</td>
                            <td>2</td>
                            <td>32</td>
                            <td><span class="status status-pending">قيد المراجعة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>أحمد رامي محمد</td>
                            <td>الحديث الشريف</td>
                            <td>1 أبريل 2025</td>
                            <td>4</td>
                            <td>58</td>
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
                            <td>سعيد محمد علي</td>
                            <td>العقيدة</td>
                            <td>28 مارس 2025</td>
                            <td>1</td>
                            <td>15</td>
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
                            <td>محمود عبد الله</td>
                            <td>القرآن الكريم</td>
                            <td>25 مارس 2025</td>
                            <td>3</td>
                            <td>38</td>
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
                            <td>عبد الرحمن محمد</td>
                            <td>الفقه</td>
                            <td>20 مارس 2025</td>
                            <td>2</td>
                            <td>27</td>
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
                            <td>يوسف أحمد</td>
                            <td>الحديث الشريف</td>
                            <td>15 مارس 2025</td>
                            <td>1</td>
                            <td>18</td>
                            <td><span class="status status-pending">قيد المراجعة</span></td>
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

    <!-- Add Teacher Modal -->
    <div class="modal" id="addTeacherModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">إضافة أستاذ جديد</div>
                <button class="close-btn" id="closeAddTeacherModal">&times;</button>
            </div>
            <form>
                <div class="form-group">
                    <label class="form-label">الاسم الكامل</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">رقم الهاتف</label>
                    <input type="tel" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">التخصص</label>
                    <select class="form-input" required>
                        <option value="">اختر التخصص</option>
                        <option value="quran">القرآن الكريم</option>
                        <option value="hadith">الحديث الشريف</option>
                        <option value="fiqh">الفقه</option>
                        <option value="aqidah">العقيدة</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">المؤهلات العلمية</label>
                    <textarea class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">تأكيد كلمة المرور</label>
                    <input type="password" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">الحالة</label>
                    <select class="form-input" required>
                        <option value="active">نشط</option>
                        <option value="pending">قيد المراجعة</option>
                        <option value="inactive">غير نشط</option>
                    </select>
                </div>
                <button type="submit" class="form-submit">إضافة الأستاذ</button>
            </form>
        </div>
    </div>

    <script>
        // Modal Functions
        const openAddTeacherModal = document.getElementById('openAddTeacherModal');
        const closeAddTeacherModal = document.getElementById('closeAddTeacherModal');
        const addTeacherModal = document.getElementById('addTeacherModal');

        openAddTeacherModal.addEventListener('click', function() {
            addTeacherModal.style.display = 'flex';
        });

        closeAddTeacherModal.addEventListener('click', function() {
            addTeacherModal.style.display = 'none';
        });

        window.addEventListener('click', function(event) {
            if (event.target == addTeacherModal) {
                addTeacherModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>