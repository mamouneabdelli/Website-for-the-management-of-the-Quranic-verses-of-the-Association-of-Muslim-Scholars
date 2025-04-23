<?php

require_once __DIR__ .'/template/header.php';

?>


<link rel="stylesheet" href="css/progress.css">

        <div class="content">
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

            <div class="progress-section">
                <div class="section-title">
                    متابعة التقدم
                    <span>إجمالي: 3 تقييمات</span>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث في التقييمات...">
                </div>
                <table class="progress-table">
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th>السورة</th>
                            <th>الآيات</th>
                            <th>التقييم</th>
                            <th>ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>20 أبريل 2025</td>
                            <td>سورة البقرة</td>
                            <td>1-10</td>
                            <td><span class="evaluation evaluation-good">ممتاز</span></td>
                            <td>حفظ ممتاز، يحتاج إلى تحسين التجويد</td>
                        </tr>
                        <tr>
                            <td>15 أبريل 2025</td>
                            <td>سورة آل عمران</td>
                            <td>1-5</td>
                            <td><span class="evaluation evaluation-average">متوسط</span></td>
                            <td>يحتاج إلى مراجعة يومية</td>
                        </tr>
                        <tr>
                            <td>10 أبريل 2025</td>
                            <td>سورة النساء</td>
                            <td>1-7</td>
                            <td><span class="evaluation evaluation-good">جيد جدا</span></td>
                            <td>تقدم ملحوظ في الحفظ</td>
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