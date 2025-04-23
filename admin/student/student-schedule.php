<?php

require_once __DIR__ .'/template/header.php';

?>

<link rel="stylesheet" href="css/schedule.css">

        <div class="content">
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
                            <td>الإثنين</td>
                            <td>09:00 - 10:30 ص</td>
                            <td>تجويد القرآن</td>
                            <td>أ. علي حسن</td>
                            <td>قاعة 2</td>
                        </tr>
                        <tr>
                            <td>الثلاثاء</td>
                            <td>14:00 - 15:30 م</td>
                            <td>حفظ القرآن</td>
                            <td>أ. محمد عبد الرحمن</td>
                            <td>قاعة 1</td>
                        </tr>
                        <tr>
                            <td>الأربعاء</td>
                            <td>11:00 - 12:30 م</td>
                            <td>فقه القرآن</td>
                            <td>أ. أحمد علي</td>
                            <td>قاعة 3</td>
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
        </div>
    </div>

    <script>
        document.querySelector('.search-bar input').addEventListener('input', () => {
            alert('البحث قيد التطوير! يرجى إضافة منطق البحث لاحقًا.');
        });
    </script>
</body>
</html>