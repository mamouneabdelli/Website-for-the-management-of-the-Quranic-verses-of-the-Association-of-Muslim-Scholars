
<?php

require_once __DIR__ .'/template/header.php';



?>

<link rel="stylesheet" href="css/messages.css">
        <div class="content">
            <div class="messages-section">
                <div class="section-title">
                    الرسائل المستلمة
                    <span>إجمالي: 3 رسائل</span>
                </div>
                <div class="message-summary">
                    <p>رسائل غير مقروءة: 1</p>
                    <p>رسائل هذا الأسبوع: 2</p>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في الرسائل...">
                </div>
                <div class="message-card">
                    <div class="message-info">
                        <h4>إعلان عن موعد اختبار</h4>
                        <p>من: أ. محمد عبد الرحمن | تاريخ: 20 أبريل 2025</p>
                    </div>
                    <div class="message-actions">
                        <button data-message="إعلان عن موعد اختبار: الاختبار سيعقد يوم الأحد القادم في قاعة 1."><i class="fas fa-eye"></i> عرض</button>
                    </div>
                </div>
                <div class="message-card">
                    <div class="message-info">
                        <h4>تذكير بحلقة القرآن</h4>
                        <p>من: أ. أحمد علي | تاريخ: 18 أبريل 2025</p>
                    </div>
                    <div class="message-actions">
                        <button data-message="تذكير: حلقة القرآن يوم الثلاثاء الساعة 14:00."><i class="fas fa-eye"></i> عرض</button>
                    </div>
                </div>
                <div class="message-card">
                    <div class="message-info">
                        <h4>ملاحظات على الحفظ</h4>
                        <p>من: أ. محمد عبد الرحمن | تاريخ: 15 أبريل 2025</p>
                    </div>
                    <div class="message-actions">
                        <button data-message="ملاحظات: تحسن ملحوظ في الحفظ، استمر في المراجعة اليومية."><i class="fas fa-eye"></i> عرض</button>
                    </div>
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

        document.querySelector('.search-bar input').addEventListener('input', () => {
            alert('البحث قيد التطوير! يرجى إضافة منطق البحث لاحقًا.');
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