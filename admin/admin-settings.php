<?php

require_once __DIR__ .'/template/header.php';

?>

<link rel="stylesheet" href="CSS/admin-settings.css">

        <div class="content">
            <div class="search-bar">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في الإعدادات...">
                </div>
                <button class="save-btn" onclick="saveSettings()">
                    <i class="fas fa-save"></i> حفظ الإعدادات
                </button>
            </div>

            <div class="settings-section">
                <div class="section-title">
                    إعدادات النظام
                </div>

                <div class="tabs">
                    <div class="tab active">الإعدادات العامة</div>
                    <div class="tab">إعدادات الإشعارات</div>
                    <div class="tab">إعدادات الأمان</div>
                    <div class="tab">إعدادات العرض</div>
                </div>

                <!-- General Settings -->
                <div class="settings-content" id="general-settings">
                    <form>
                        <div class="form-group">
                            <label class="form-label">اسم المؤسسة</label>
                            <input type="text" class="form-input" value="جمعية العلماء المسلمين الجزائريين" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">البريد الإلكتروني الرسمي</label>
                            <input type="email" class="form-input" value="contact@muslimscholars.dz" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">رقم الهاتف الرسمي</label>
                            <input type="tel" class="form-input" value="+213 123 456 789" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">اللغة الافتراضية</label>
                            <select class="form-select">
                                <option value="ar" selected>العربية</option>
                                <option value="fr">الفرنسية</option>
                                <option value="en">الإنجليزية</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">المنطقة الزمنية</label>
                            <select class="form-select">
                                <option value="Africa/Algiers" selected>الجزائر (UTC+1)</option>
                                <option value="Africa/Cairo">القاهرة (UTC+2)</option>
                                <option value="Europe/London">لندن (UTC+0)</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Notification Settings -->
                <div class="settings-content" id="notification-settings" style="display: none;">
                    <form>
                        <div class="form-group">
                            <label class="form-label">إشعارات البريد الإلكتروني</label>
                            <label><input type="checkbox" class="form-checkbox" checked> إرسال إشعارات البريد للأساتذة</label>
                            <label><input type="checkbox" class="form-checkbox" checked> إرسال إشعارات البريد للطلاب</label>
                            <label><input type="checkbox" class="form-checkbox"> إرسال إشعارات البريد لأولياء الأمور</label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">إشعارات الجوال</label>
                            <label><input type="checkbox" class="form-checkbox"> إرسال إشعارات SMS للأساتذة</label>
                            <label><input type="checkbox" class="form-checkbox"> إرسال إشعارات SMS للطلاب</label>
                            <label><input type="checkbox" class="form-checkbox"> إرسال إشعارات التطبيق</label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">تذكيرات الحلقات</label>
                            <select class="form-select">
                                <option value="none">بدون تذكيرات</option>
                                <option value="1hour" selected>قبل ساعة</option>
                                <option value="2hours">قبل ساعتين</option>
                                <option value="1day">قبل يوم</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Security Settings -->
                <div class="settings-content" id="security-settings" style="display: none;">
                    <form>
                        <div class="form-group">
                            <label class="form-label">تفعيل المصادقة الثنائية</label>
                            <label><input type="checkbox" class="form-checkbox"> تفعيل المصادقة الثنائية للمديرين</label>
                            <label><input type="checkbox" class="form-checkbox"> تفعيل المصادقة الثنائية للأساتذة</label>
                        </div>
                        <div class="form-group">
                            <label class="form-label">مدة جلسة تسجيل الدخول</label>
                            <select class="form-select">
                                <option value="30min">30 دقيقة</option>
                                <option value="1hour" selected>ساعة واحدة</option>
                                <option value="2hours">ساعتين</option>
                                <option value="1day">يوم واحد</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">سياسة كلمة المرور</label>
                            <label><input type="checkbox" class="form-checkbox" checked> يجب أن تحتوي على 8 أحرف على الأقل</label>
                            <label><input type="checkbox" class="form-checkbox" checked> يجب أن تحتوي على أرقام</label>
                            <label><input type="checkbox" class="form-checkbox"> يجب أن تحتوي على رموز خاصة</label>
                        </div>
                    </form>
                </div>

                <!-- Display Settings -->
                <div class="settings-content" id="display-settings" style="display: none;">
                    <form>
                        <div class="form-group">
                            <label class="form-label">وضع العرض</label>
                            <select class="form-select">
                                <option value="light" selected>الوضع الفاتح</option>
                                <option value="dark">الوضع الداكن</option>
                                <option value="auto">تلقائي</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">حجم الخط</label>
                            <select class="form-select">
                                <option value="small">صغير</option>
                                <option value="medium" selected>متوسط</option>
                                <option value="large">كبير</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">اللون الأساسي</label>
                            <input type="color" class="form-input" value="#00A841">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        const tabs = document.querySelectorAll('.tab');
        const settingsContents = document.querySelectorAll('.settings-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                settingsContents.forEach(content => content.style.display = 'none');
                const contentId = tab.textContent.includes('العامة') ? 'general-settings' :
                                 tab.textContent.includes('الإشعارات') ? 'notification-settings' :
                                 tab.textContent.includes('الأمان') ? 'security-settings' :
                                 'display-settings';
                document.getElementById(contentId).style.display = 'block';
            });
        });

        // Save settings function
        function saveSettings() {
            alert('تم حفظ الإعدادات بنجاح!');
            // Add logic to save settings to backend
        }
    </script>
</body>
</html>