<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب - جمعية العلماء المسلمين</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            background-color: #F2F9FF;
            color: #333;
        }

        /* Main Layout */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: white;
            border-bottom: 1px solid #e0e0e0;
        }

        .welcome-msg {
            color: #555;
            font-weight: bold;
            font-size: 16px;
        }

        .welcome-msg span {
            color: #000;
        }

        .header-icons {
            display: flex;
            gap: 15px;
        }

        .header-icons i {
            font-size: 20px;
            color: #555;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background-color: white;
            padding: 15px 0;
            border-left: 1px solid #e0e0e0;
        }

        .logo {
            text-align: center;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 15px;
        }

        .logo img {
            width: 120px;
            height: 90px;
            border-radius: 50%;
            background-color: #FFFFFF;
        }

        .logo p {
            font-size: 14px;
            margin-top: 8px;
            color: #333;
            font-weight: 600;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 15px;
        }

        .sidebar-menu li {
            background-color: #E6F6EC;
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .sidebar-menu li:hover {
            background-color: #00A841;
            color: white;
        }

        .sidebar-menu li.active {
            background-color: #E6F6EC;
            color: #00A841;
            border-right: 4px solid #00A841;
        }

        .register-btn {
            background-color: #000;
            color: white;
            padding: 12px;
            text-align: center;
            margin: 15px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Main Content Styles */
        .content {
            flex: 1;
            padding: 20px;
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .search-input {
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
            border-radius: 20px;
            padding: 8px 15px;
            width: 300px;
        }

        .search-input input {
            border: none;
            background: transparent;
            width: 100%;
            padding-right: 10px;
            outline: none;
        }

        .add-btn {
            background-color: #00A841;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Stats Cards */
        .stats-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }

        .stat-card .number {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-card .label {
            color: #666;
            font-size: 12px;
        }

        .blue { color: #2196F3; }
        .green { color: #00A841; }
        .red { color: #ff5252; }
        .orange { color: #FF9800; }

        /* Filter Section */
        .filter-section {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .filter-title {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .filter-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .filter-select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            outline: none;
        }

        /* Students Table */
        .admin-section {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th {
            background-color: #E6F7E9;
            padding: 12px;
            text-align: right;
            font-weight: bold;
        }

        .admin-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .progress-bar {
            height: 8px;
            background-color: #f0f0f0;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 5px;
        }

        .progress-fill {
            height: 100%;
            background-color: #00A841;
        }

        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            display: inline-block;
        }

        .status-active {
            background-color: #E6F7E9;
            color: #00A841;
        }

        .status-pending {
            background-color: #FFF3E0;
            color: #FF9800;
        }

        .status-inactive {
            background-color: #FFEBEE;
            color: #ff5252;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-button {
            background-color: transparent;
            border: none;
            color: #00A841;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-button.delete {
            color: #ff5252;
        }

        .action-button.view {
            color: #2196F3;
        }

        /* Tabs */
        .tabs {
            display: flex;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 15px;
            margin-left: 5px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .tab.active {
            border-bottom: 2px solid #00A841;
            color: #00A841;
            font-weight: bold;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }

        .page-item {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            background-color: #f5f5f5;
            cursor: pointer;
        }

        .page-item.active {
            background-color: #00A841;
            color: white;
        }

        /* Add Student Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 500px;
            max-width: 90%;
            padding: 20px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: bold;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-input {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-submit {
            background-color: #00A841;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 10px;
        }

        /* Sidebar Menu Links */
        .sidebar-menu a {
            text-decoration: none;
            color: black;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .stats-cards {
                flex-wrap: wrap;
            }
            
            .stat-card {
                flex: 1 1 calc(50% - 15px);
            }
            
            .filter-options {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-left: none;
                border-bottom: 1px solid #e0e0e0;
            }

            .search-bar {
                flex-direction: column;
                gap: 10px;
            }

            .search-input {
                width: 100%;
            }
            
            .stat-card {
                flex: 1 1 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="welcome-msg">
            أهلا بك يا <span>المدير أحمد</span>
        </div>
        <div class="header-icons">
            <i class="fas fa-bell"></i>
            <i class="fas fa-envelope"></i>
            <i class="fas fa-cog"></i>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="logo.png" alt="جمعية العلماء المسلمين">
                <p>جمعية العلماء المسلمين الجزائريين</p>
            </div>
            <ul class="sidebar-menu">
                <li>
                    <a href="index.html">لوحة التحكم</a>
                </li>
                <li>
                    <a href="admin-users.html">إدارة المستخدمين</a>
                </li>
                <li>
                    <a href="admin-teachers.html">إدارة الأساتذة</a>
                </li>
                <li style="background-color:#B0E4C4;" class="active">
                    <a href="admin-students.html">إدارة الطلاب</a>
                </li>
                <li>
                    <a href="admin-sessions.html">إدارة الحلقات</a>
                </li>
                <li>
                    <a href="admin-reports.html">التقارير والإحصائيات</a>
                </li>
                <li>
                    <a href="admin-settings.html">إعدادات النظام</a>
                </li>
            </ul>
            <div class="register-btn">
                <i class="fas fa-arrow-left"></i> تسجيل الخروج
            </div>
        </div>

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
                    <div class="tab">الطلاب الجدد</div>
                    <div class="tab">المتفوقون</div>
                    <div class="tab">يحتاج للمتابعة</div>
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