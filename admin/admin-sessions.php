<?php
$ac_session = "active";
require_once __DIR__ .'/template/header.php';

?>

<link rel="stylesheet" href="CSS/admin-sessions.css">

        <div class="content">
            <div class="search-bar">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث عن حلقة...">
                </div>
                <button class="add-btn" id="openAddSessionModal">
                    <i class="fas fa-plus"></i> إضافة حلقة جديدة
                </button>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="number blue">18</div>
                    <div class="label">إجمالي الحلقات</div>
                </div>
                <div class="stat-card">
                    <div class="number green">245</div>
                    <div class="label">إجمالي الطلاب في الحلقات</div>
                </div>
                <div class="stat-card">
                    <div class="number red">12</div>
                    <div class="label">الأساتذة المشرفين</div>
                </div>
                <div class="stat-card">
                    <div class="number orange">92%</div>
                    <div class="label">معدل الانتظام</div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-title">تصفية النتائج</div>
                <div class="filter-options">
                    <div class="filter-option">
                        <label>نوع الحلقة:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="quran">حلقات القرآن</option>
                            <option value="hadith">حلقات الحديث</option>
                            <option value="fiqh">حلقات الفقه</option>
                            <option value="tafsir">حلقات التفسير</option>
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
                        <label>الأستاذ المشرف:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="1">أ. محمد عبد الرحمن</option>
                            <option value="2">أ. أحمد علي</option>
                            <option value="3">أ. خالد محمود</option>
                            <option value="4">أ. عبد الله سعيد</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>الترتيب:</label>
                        <select class="filter-select">
                            <option value="newest">الأحدث</option>
                            <option value="oldest">الأقدم</option>
                            <option value="name">الاسم (أ-ي)</option>
                            <option value="students">عدد الطلاب</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-title">
                    قائمة الحلقات
                    <span>إجمالي: 18 حلقة</span>
                </div>

                <div class="tabs">
                    <div class="tab active">جميع الحلقات</div>
                    <div class="tab">حلقات القرآن</div>
                    <div class="tab">حلقات الحديث</div>
                    <div class="tab">حلقات الفقه</div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>اسم الحلقة</th>
                            <th>الأستاذ المشرف</th>
                            <th>عدد الطلاب</th>
                            <th>المستوى</th>
                            <th>أيام الانعقاد</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>حلقة القرآن 1</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>45 طالب</td>
                            <td>مبتدئ</td>
                            <td>السبت - الاثنين - الأربعاء</td>
                            <td><span class="status status-active">نشطة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>حلقة القرآن 2</td>
                            <td>أ. أحمد علي</td>
                            <td>38 طالب</td>
                            <td>متوسط</td>
                            <td>الأحد - الثلاثاء - الخميس</td>
                            <td><span class="status status-active">نشطة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>حلقة الحديث 1</td>
                            <td>أ. خالد محمود</td>
                            <td>32 طالب</td>
                            <td>مبتدئ</td>
                            <td>السبت - الثلاثاء</td>
                            <td><span class="status status-active">نشطة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>حلقة الفقه 1</td>
                            <td>أ. عبد الله سعيد</td>
                            <td>28 طالب</td>
                            <td>متقدم</td>
                            <td>الأحد - الأربعاء</td>
                            <td><span class="status status-active">نشطة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>حلقة التفسير 1</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>22 طالب</td>
                            <td>متوسط</td>
                            <td>الإثنين - الخميس</td>
                            <td><span class="status status-inactive">معلقة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>حلقة الحديث 2</td>
                            <td>أ. أحمد علي</td>
                            <td>25 طالب</td>
                            <td>متقدم</td>
                            <td>السبت - الثلاثاء</td>
                            <td><span class="status status-active">نشطة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>حلقة القرآن المكثفة</td>
                            <td>أ. خالد محمود</td>
                            <td>15 طالب</td>
                            <td>متقدم</td>
                            <td>يوميًا (السبت-الخميس)</td>
                            <td><span class="status status-active">نشطة</span></td>
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
                    <div class="page-item"><i class="fas fa-angle-double-left"></i></div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-title">
                    تفاصيل الحلقة
                    <span>حلقة القرآن 1</span>
                </div>

                <div class="session-details">
                    <div class="detail-card">
                        <h3>معلومات الحلقة</h3>
                        <div class="detail-info">
                            <div class="detail-item">
                                <span class="detail-label">اسم الحلقة:</span>
                                <span class="detail-value">حلقة القرآن 1</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">نوع الحلقة:</span>
                                <span class="detail-value">حفظ وتجويد</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">المستوى:</span>
                                <span class="detail-value">مبتدئ</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">تاريخ البدء:</span>
                                <span class="detail-value">15 فبراير 2025</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">القاعة:</span>
                                <span class="detail-value">قاعة 3 - الطابق الأول</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h3>إحصائيات الحلقة</h3>
                        <div class="detail-info">
                            <div class="detail-item">
                                <span class="detail-label">عدد الطلاب:</span>
                                <span class="detail-value">45 طالب</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">متوسط الحضور:</span>
                                <span class="detail-value">89%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">عدد الحصص المنعقدة:</span>
                                <span class="detail-value">35 حصة</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">معدل الإنجاز:</span>
                                <span class="detail-value">72%</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">عدد الحفظة:</span>
                                <span class="detail-value">15 طالب</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h3>معلومات الأستاذ المشرف</h3>
                        <div class="detail-info">
                            <div class="detail-item">
                                <span class="detail-label">الاسم:</span>
                                <span class="detail-value">أ. محمد عبد الرحمن</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">التخصص:</span>
                                <span class="detail-value">علوم القرآن والتفسير</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">المؤهل العلمي:</span>
                                <span class="detail-value">ماجستير علوم إسلامية</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">رقم الهاتف:</span>
                                <span class="detail-value">0551234567</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">البريد الإلكتروني:</span>
                                <span class="detail-value">mohammed@example.com</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-card">
                        <h3>المحتوى التعليمي</h3>
                        <div class="detail-info">
                            <div class="detail-item">
                                <span class="detail-label">المنهج:</span>
                                <span class="detail-value">منهج الجمعية لتعليم القرآن</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">المقرر الحالي:</span>
                                <span class="detail-value">سورة البقرة (الجزء الأول)</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">المراجع:</span>
                                <span class="detail-value">مذكرة التجويد الميسر، كتاب أحكام التلاوة</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">الاختبارات:</span>
                                <span class="detail-value">3 اختبارات منجزة من أصل 5</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">تقدم المنهج:</span>
                                <span class="detail-value">65%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="session-schedule">
                    <h3 style="margin-bottom: 15px;">جدول الحلقة الأسبوعي</h3>
                    
                    <div class="schedule-day">
                        <div class="day-name">السبت</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-clock"></i>
                                8:00 - 10:00 صباحاً
                            </div>
                        </div>
                    </div>
                    
                    <div class="schedule-day">
                        <div class="day-name">الأحد</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-times"></i>
                                لا توجد حصص
                            </div>
                        </div>
                    </div>
                    
                    <div class="schedule-day">
                        <div class="day-name">الإثنين</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-clock"></i>
                                8:00 - 10:00 صباحاً
                            </div>
                        </div>
                    </div>
                    
                    <div class="schedule-day">
                        <div class="day-name">الثلاثاء</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-times"></i>
                                لا توجد حصص
                            </div>
                        </div>
                    </div>
                    
                    <div class="schedule-day">
                        <div class="day-name">الأربعاء</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-clock"></i>
                                8:00 - 10:00 صباحاً
                            </div>
                            <div class="time-slot">
                                <i class="fas fa-clock"></i>
                                4:00 - 6:00 مساءً (تسميع)
                            </div>
                        </div>
                    </div>
                    
                    <div class="schedule-day">
                        <div class="day-name">الخميس</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-times"></i>
                                لا توجد حصص
                            </div>
                        </div>
                    </div>
                    
                    <div class="schedule-day">
                        <div class="day-name">الجمعة</div>
                        <div class="time-slots">
                            <div class="time-slot">
                                <i class="fas fa-times"></i>
                                لا توجد حصص
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Session Modal -->
    <div class="modal" id="addSessionModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">إضافة حلقة جديدة</div>
                <button class="close-btn" id="closeAddSessionModal">&times;</button>
            </div>
            <form>
                <div class="form-group">
                    <label class="form-label">اسم الحلقة</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">نوع الحلقة</label>
                    <select class="form-input" required>
                        <option value="">اختر نوع الحلقة</option>
                        <option value="quran">حلقة قرآن (حفظ وتجويد)</option>
                        <option value="hadith">حلقة حديث</option>
                        <option value="fiqh">حلقة فقه</option>
                        <option value="tafsir">حلقة تفسير</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">الأستاذ المشرف</label>
                    <select class="form-input" required>
                        <option value="">اختر الأستاذ</option>
                        <option value="1">أ. محمد عبد الرحمن</option>
                        <option value="2">أ. أحمد علي</option>
                        <option value="3">أ. خالد محمود</option>
                        <option value="4">أ. عبد الله سعيد</option>
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
                    <label class="form-label">تاريخ البدء</label>
                    <input type="date" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">القاعة</label>
                    <select class="form-input" required>
                        <option value="">اختر القاعة</option>
                        <option value="1">قاعة 1 - الطابق الأرضي</option>
                        <option value="2">قاعة 2 - الطابق الأرضي</option>
                        <option value="3">قاعة 3 - الطابق الأول</option>
                        <option value="4">قاعة 4 - الطابق الأول</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">الحد الأقصى للطلاب</label>
                    <input type="number" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">أيام الانعقاد</label>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="days[]" value="saturday"> السبت
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="days[]" value="sunday"> الأحد
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="days[]" value="monday"> الإثنين
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="days[]" value="tuesday"> الثلاثاء
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="days[]" value="wednesday"> الأربعاء
                        </label>
                        <label style="display: flex; align-items: center; gap: 5px;">
                            <input type="checkbox" name="days[]" value="thursday"> الخميس
                        </label>
                    </div>
                </div>
                <button type="submit" class="form-submit">إضافة الحلقة</button>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const openAddSessionModal = document.getElementById('openAddSessionModal');
        const closeAddSessionModal = document.getElementById('closeAddSessionModal');
        const addSessionModal = document.getElementById('addSessionModal');

        openAddSessionModal.addEventListener('click', function() {
            addSessionModal.style.display = 'flex';
        });

        closeAddSessionModal.addEventListener('click', function() {
            addSessionModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === addSessionModal) {
                addSessionModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>