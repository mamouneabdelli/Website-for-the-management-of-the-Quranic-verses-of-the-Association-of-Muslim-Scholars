<?php

require_once __DIR__ . '/template/header.php';

 ?>

 <link rel="stylesheet" href="CSS/style.css">

    <div class="content">
        <div class="search-bar">
            <div class="search-input">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="بحث...">
            </div>
            <button class="add-btn">
                <i class="fas fa-sync-alt"></i> تحديث النظام
            </button>
        </div>

        <div class="stats-cards">
            <div class="stat-card">
                <div class="number blue">40</div>
                <div class="label">إجمالي الأساتذة</div>
            </div>
            <div class="stat-card">
                <div class="number green">523</div>
                <div class="label">إجمالي الطلاب</div>
            </div>
            <div class="stat-card">
                <div class="number red">86</div>
                <div class="label">الحلقات النشطة</div>
            </div>
            <div class="stat-card">
                <div class="number orange">95%</div>
                <div class="label">نسبة الحضور</div>
            </div>
        </div>

        <div class="dashboard-cards">
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-blue">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="dashboard-card-number">12</div>
                <div class="dashboard-card-title">أساتذة جدد هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-up"></i> 18% مقارنة بالشهر الماضي
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="dashboard-card-number">87</div>
                <div class="dashboard-card-title">طلاب جدد هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-up"></i> 23% مقارنة بالشهر الماضي
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-red">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="dashboard-card-number">56</div>
                <div class="dashboard-card-title">حلقات مكتملة هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-up"></i> 12% مقارنة بالشهر الماضي
                </div>
            </div>
            <div class="dashboard-card">
                <div class="dashboard-card-icon bg-orange">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="dashboard-card-number">34</div>
                <div class="dashboard-card-title">تقارير جديدة هذا الشهر</div>
                <div class="dashboard-card-footer">
                    <i class="fas fa-arrow-down"></i> 5% مقارنة بالشهر الماضي
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="section-title">
                أحدث الأساتذة المنضمين
                <span class="view-all">عرض الكل</span>
            </div>
            <table class="admin-table">
                <thead>
                <tr>
                    <th>اسم الأستاذ</th>
                    <th>تاريخ الانضمام</th>
                    <th>الحلقات</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>محمد علي</td>
                    <td>10 أبريل 2025</td>
                    <td>3</td>
                    <td><span class="status status-active">نشط</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                            <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>خالد محمود</td>
                    <td>5 أبريل 2025</td>
                    <td>2</td>
                    <td><span class="status status-pending">قيد المراجعة</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                            <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>أحمد رامي</td>
                    <td>1 أبريل 2025</td>
                    <td>4</td>
                    <td><span class="status status-active">نشط</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="action-button"><i class="fas fa-edit"></i> تعديل</button>
                            <button class="action-button delete"><i class="fas fa-trash"></i> حذف</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <div class="tabs">
                <div class="tab active">النشاط الأخير</div>
                <div class="tab">الإشعارات</div>
                <div class="tab">طلبات جديدة</div>
            </div>

            <div class="notification-list">
                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تم تسجيل طالب جديد</div>
                        <div class="notification-message">تم تسجيل الطالب عبد الله محمد في حلقة القرآن رقم 2</div>
                        <div class="notification-time">قبل 10 دقائق</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تقرير جديد</div>
                        <div class="notification-message">قام الأستاذ محمد علي بإرسال تقرير أداء الطلاب لشهر أبريل</div>
                        <div class="notification-time">قبل ساعة واحدة</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تنبيه حول نسبة الغياب</div>
                        <div class="notification-message">ارتفعت نسبة الغياب في حلقة القرآن رقم 3 إلى 20%</div>
                        <div class="notification-time">قبل 3 ساعات</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">تم إنشاء حلقة جديدة</div>
                        <div class="notification-message">تم إنشاء حلقة القرآن رقم 5 بواسطة الأستاذ أحمد رامي</div>
                        <div class="notification-time">قبل 5 ساعات</div>
                    </div>
                </div>

                <div class="notification-item">
                    <div class="notification-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">إنجاز جديد</div>
                        <div class="notification-message">أكمل الطالب محمد عبد الله حفظ سورة البقرة</div>
                        <div class="notification-time">قبل 7 ساعات</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="section-title">نشاط الحلقات (آخر 7 أيام)</div>
            <div class="chart-container">
                <div class="chart-bars">
                    <div class="chart-bar" style="height: 65%;" data-value="65%"></div>
                    <div class="chart-bar" style="height: 80%;" data-value="80%"></div>
                    <div class="chart-bar" style="height: 95%;" data-value="95%"></div>
                    <div class="chart-bar" style="height: 75%;" data-value="75%"></div>
                    <div class="chart-bar" style="height: 85%;" data-value="85%"></div>
                    <div class="chart-bar" style="height: 90%;" data-value="90%"></div>
                    <div class="chart-bar" style="height: 70%;" data-value="70%"></div>
                </div>
                <div class="chart-labels">
                    <div class="chart-label">الجمعة</div>
                    <div class="chart-label">السبت</div>
                    <div class="chart-label">الأحد</div>
                    <div class="chart-label">الإثنين</div>
                    <div class="chart-label">الثلاثاء</div>
                    <div class="chart-label">الأربعاء</div>
                    <div class="chart-label">الخميس</div>
                </div>
            </div>
        </div>

        <div class="admin-section">
            <div class="section-title">التقارير السريعة</div>
            <div class="reports-grid">
                <div class="report-card">
                    <div class="report-card-icon bg-blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="report-card-title">تقرير الحضور</div>
                    <div class="report-card-desc">تقرير مفصل عن حضور الطلاب في جميع الحلقات</div>
                    <div class="report-card-link">
                        <i class="fas fa-arrow-circle-left"></i> عرض التقرير
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-card-icon bg-green">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="report-card-title">تقرير الأداء</div>
                    <div class="report-card-desc">تقرير عن أداء الطلاب والحفظ والمراجعة</div>
                    <div class="report-card-link">
                        <i class="fas fa-arrow-circle-left"></i> عرض التقرير
                    </div>
                </div>

                <div class="report-card">
                    <div class="report-card-icon bg-orange">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="report-card-title">تقرير الإنجازات</div>
                    <div class="report-card-desc">تقرير عن إنجازات الطلاب وحفظ السور</div>
                    <div class="report-card-link">
                        <i class="fas fa-arrow-circle-left"></i> عرض التقرير
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // يمكن إضافة التفاعل