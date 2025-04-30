<?php

require_once __DIR__ .'/template/header.php';

?>

<link rel="stylesheet" href="CSS/admin-reports.css">

        <div class="content">
            <div class="search-bar">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث عن تقرير أو رسالة...">
                </div>
                <button class="add-btn" id="openSendMessageModal">
                    <i class="fas fa-plus"></i> إرسال رسالة جديدة
                </button>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="number blue">45</div>
                    <div class="label">إجمالي التقارير</div>
                </div>
                <div class="stat-card">
                    <div class="number green">120</div>
                    <div class="label">الرسائل المرسلة</div>
                </div>
                <div class="stat-card">
                    <div class="number red">15</div>
                    <div class="label">الرسائل المستلمة</div>
                </div>
                <div class="stat-card">
                    <div class="number orange">8</div>
                    <div class="label">التقارير المعلقة</div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-title">تصفية النتائج</div>
                <div class="filter-options">
                    <div class="filter-option">
                        <label>نوع التقرير/الرسالة:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="attendance">تقارير الحضور</option>
                            <option value="performance">تقارير الأداء</option>
                            <option value="messages">الرسائل</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>التاريخ:</label>
                        <select class="filter-select">
                            <option value="all">الكل</option>
                            <option value="today">اليوم</option>
                            <option value="week">هذا الأسبوع</option>
                            <option value="month">هذا الشهر</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>المرسل/المتلقي:</label>
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
                            <option value="title">العنوان</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-title">
                    قائمة التقارير والرسائل
                    <span>إجمالي: 45 عنصر</span>
                </div>

                <div class="tabs">
                    <div class="tab active">الكل</div>
                    <div class="tab">تقارير الحضور</div>
                    <div class="tab">تقارير الأداء</div>
                    <div class="tab">الرسائل</div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>النوع</th>
                            <th>المرسل/المتلقي</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>تقرير حضور حلقة القرآن 1</td>
                            <td>تقرير حضور</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>20 أبريل 2025</td>
                            <td><span class="status status-active">مكتمل</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>رسالة إلى أولياء الأمور</td>
                            <td>رسالة</td>
                            <td>أ. أحمد علي</td>
                            <td>19 أبريل 2025</td>
                            <td><span class="status status-active">مرسلة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>تقرير أداء الطلاب</td>
                            <td>تقرير أداء</td>
                            <td>أ. خالد محمود</td>
                            <td>18 أبريل 2025</td>
                            <td><span class="status status-pending">معلق</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>إعلان عن موعد اختبار</td>
                            <td>رسالة</td>
                            <td>أ. عبد الله سعيد</td>
                            <td>17 أبريل 2025</td>
                            <td><span class="status status-active">مرسلة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
                                    <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>تقرير حضور حلقة الحديث</td>
                            <td>تقرير حضور</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>16 أبريل 2025</td>
                            <td><span class="status status-active">مكتمل</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view"><i class="fas fa-eye"></i> عرض</button>
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
        </div>
    </div>

    <!-- Send Message Modal -->
    <div class="modal" id="sendMessageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">إرسال رسالة جديدة</div>
                <button class="close-btn" id="closeSendMessageModal">×</button>
            </div>
            <form>
                <div class="form-group">
                    <label class="form-label">المستلم</label>
                    <select class="form-input" required>
                        <option value="">اختر المستلم</option>
                        <option value="all">جميع الأساتذة</option>
                        <option value="students">جميع الطلاب</option>
                        <option value="parents">جميع أولياء الأمور</option>
                        <option value="1">أ. محمد عبد الرحمن</option>
                        <option value="2">أ. أحمد علي</option>
                        <option value="3">أ. خالد محمود</option>
                        <option value="4">أ. عبد الله سعيد</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">عنوان الرسالة</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">محتوى الرسالة</label>
                    <textarea class="form-input" rows="6" required></textarea>
                </div>
                <button type="submit" class="form-submit">إرسال الرسالة</button>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const openSendMessageModal = document.getElementById('openSendMessageModal');
        const closeSendMessageModal = document.getElementById('closeSendMessageModal');
        const sendMessageModal = document.getElementById('sendMessageModal');

        openSendMessageModal.addEventListener('click', function() {
            sendMessageModal.style.display = 'flex';
        });

        closeSendMessageModal.addEventListener('click', function() {
            sendMessageModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === sendMessageModal) {
                sendMessageModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>