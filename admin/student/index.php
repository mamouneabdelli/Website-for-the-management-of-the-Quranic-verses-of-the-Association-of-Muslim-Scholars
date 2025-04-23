<?php

require_once __DIR__ .'/template/header.php';


?>

        <div class="content">
            <div class="stats-section">
                <div class="stat-card">
                    <i class="fas fa-envelope stat-icon"></i>
                    <div class="stat-info">
                        <h4>الرسائل المستلمة</h4>
                        <p>3</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-check-circle stat-icon"></i>
                    <div class="stat-info">
                        <h4>التقييمات المكتملة</h4>
                        <p>3</p>
                    </div>
                </div>
                <div class="stat-card">
                    <i class="fas fa-star stat-icon"></i>
                    <div class="stat-info">
                        <h4>متوسط التقييم</h4>
                        <p>4.0/5</p>
                    </div>
                </div>
            </div>

            <div class="quick-links">
                <a href="student-schedule.html" class="quick-link-btn">
                    <i class="fas fa-calendar"></i> عرض البرنامج الكامل
                </a>
                <a href="student-messages.html" class="quick-link-btn">
                    <i class="fas fa-envelope"></i> قراءة جميع الرسائل
                </a>
                <a href="student-progress.html" class="quick-link-btn">
                    <i class="fas fa-chart-line"></i> متابعة التقدم
                </a>
            </div>

            <div class="schedule-section">
                <div class="section-title">
                    البرنامج الأسبوعي
                    <span>حلقة القرآن رقم 1</span>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في البرنامج...">
                </div>
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>اليوم</th>
                            <th>الوقت</th>
                            <th>المادة</th>
                            <th>الأستاذ</th>
                            <th>الموقع</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>الأحد</td>
                            <td>10:00 - 11:30 ص</td>
                            <td>تلاوة القرآن</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>قاعة 1</td>
                        </tr>
                        <tr>
                            <td>الثلاثاء</td>
                            <td>14:00 - 15:30 م</td>
                            <td>حفظ القرآن</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>قاعة 1</td>
                        </tr>
                        <tr>
                            <td>الخميس</td>
                            <td>10:00 - 11:30 ص</td>
                            <td>تفسير القرآن</td>
                            <td>أ. أحمد علي</td>
                            <td>قاعة 2</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <div class="progress-trend">
                <div class="section-title">
                    اتجاه التقدم
                    <span>آخر 3 أسابيع</span>
                </div>
                <div class="trend-chart">
                    <div class="trend-bar" style="height: 60%;"></div>
                    <div class="trend-bar" style="height: 40%;"></div>
                    <div class="trend-bar" style="height: 80%;"></div>
                </div>
                <div class="trend-labels">
                    <span>الأسبوع 1</span>
                    <span>الأسبوع 2</span>
                    <span>الأسبوع 3</span>
                </div>
            </div>

            
        </div>
    </div>

    <div class="modal" id="messageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">تفاصيل الرسالة</div>
                <button class="close-btn" id="closeMessageModal">×</button>
            </div>
            <div class="modal-body">
                <p id="messageContent"></p>
            </div>
        </div>
    </div>

    <script>
        const messageModal = document.getElementById('messageModal');
        const closeMessageModal = document.getElementById('closeMessageModal');
        const messageContent = document.getElementById('messageContent');

        document.querySelectorAll('.message-actions button').forEach(button => {
            button.addEventListener('click', () => {
                messageContent.textContent = button.getAttribute('data-message');
                messageModal.style.display = 'flex';
            });
        });

        closeMessageModal.addEventListener('click', () => {
            messageModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === messageModal) {
                messageModal.style.display = 'none';
            }
        });

        document.querySelectorAll('.search-bar input').forEach(input => {
            input.addEventListener('input', () => {
                alert('البحث قيد التطوير! يرجى إضافة منطق البحث لاحقًا.');
            });
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