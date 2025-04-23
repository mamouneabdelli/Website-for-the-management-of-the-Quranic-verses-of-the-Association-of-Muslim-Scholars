<?php

require_once __DIR__ .'/template/header.php';

?>
<link rel="stylesheet" href="css/profile.css">

        <div class="content">
            <div class="profile-section">
                <div class="section-title">
                    الملف الشخصي
                    <button class="edit-btn" id="editProfileBtn"><i class="fas fa-edit"></i> تعديل الملف</button>
                </div>
                <div class="profile-header">
                    <div class="profile-avatar">أ</div>
                    <div class="profile-info">
                        <h2>أحمد علي</h2>
                        <p>طالب في حلقة القرآن رقم 1</p>
                    </div>
                </div>
                <div class="profile-details">
                    <div class="detail-item">
                        <i class="fas fa-id-card"></i>
                        <div>
                            <label>رقم الطالب</label>
                            <span>STU12345</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-users"></i>
                        <div>
                            <label>المجموعة</label>
                            <span>حلقة القرآن رقم 1</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <label>البريد الإلكتروني</label>
                            <span>ahmed.ali@example.com</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <label>رقم الهاتف</label>
                            <span>+213 123 456 789</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <label>تاريخ التسجيل</label>
                            <span>1 يناير 2025</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <label>العنوان</label>
                            <span>الجزائر العاصمة، الجزائر</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="progress-summary">
                <div class="section-title">
                    ملخص التقدم
                </div>
                <div class="summary-item">
                    <i class="fas fa-check-circle"></i>
                    <div>
                        <label>إجمالي التقييمات</label>
                        <span>3</span>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-star"></i>
                    <div>
                        <label>متوسط التقييم</label>
                        <span>4.0/5</span>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="fas fa-medal"></i>
                    <div>
                        <label>آخر تقييم</label>
                        <span>ممتاز (20 أبريل 2025)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="editProfileModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">تعديل الملف الشخصي</div>
                <button class="close-btn" id="closeEditModal">×</button>
            </div>
            <div class="modal-body">
                <label>البريد الإلكتروني</label>
                <input type="email" value="ahmed.ali@example.com">
                <label>رقم الهاتف</label>
                <input type="tel" value="+213 123 456 789">
                <button>حفظ التغييرات</button>
            </div>
        </div>
    </div>

    <script>
        const editProfileModal = document.getElementById('editProfileModal');
        const editProfileBtn = document.getElementById('editProfileBtn');
        const closeEditModal = document.getElementById('closeEditModal');

        editProfileBtn.addEventListener('click', () => {
            editProfileModal.style.display = 'flex';
        });

        closeEditModal.addEventListener('click', () => {
            editProfileModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === editProfileModal) {
                editProfileModal.style.display = 'none';
            }
        });

        document.querySelector('.modal-body button').addEventListener('click', () => {
            alert('حفظ التغييرات قيد التطوير! يرجى إضافة منطق الحفظ لاحقًا.');
        });
    </script>
    <script type="text/javascript">
        var gk_isXlsx = false;
        var gk_xlsxFileLookup = {};
        var gk_fileData = {};
        function filledCell(cell) {
          return cell !== '' && cell != null;
        }
        function loadFileData(filename) {
        if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
            try {
                var workbook = XLSX.read(gk_fileData[filename], { type: 'base64' });
                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];

                // Convert sheet to JSON to filter blank rows
                var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
                // Filter out blank rows (rows where all cells are empty, null, or undefined)
                var filteredData = jsonData.filter(row => row.some(filledCell));

                // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
                var headerRowIndex = filteredData.findIndex((row, index) =>
                  row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
                );
                // Fallback
                if (headerRowIndex === -1 || headerRowIndex > 25) {
                  headerRowIndex = 0;
                }

                // Convert filtered JSON back to CSV
                var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
                csv = XLSX.utils.sheet_to_csv(csv, { header: 1 });
                return csv;
            } catch (e) {
                console.error(e);
                return "";
            }
        }
        return gk_fileData[filename] || "";
        }
        </script>
</body>
</html>