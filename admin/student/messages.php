<?php

require_once __DIR__.'/../template/header.php';
?>

                <!-- الرسائل والمحادثات -->
                <div class="messages-tab">
                    <button class="tab-btn active" id="inbox-tab">صندوق الوارد</button>
                    <button class="tab-btn" id="sent-tab">الرسائل المرسلة</button>
                    <button class="tab-btn" id="compose-tab">إنشاء رسالة جديدة</button>
                </div>

                <!-- صندوق الوارد -->
                <div class="messages-container" id="inbox-content">
                    <div class="section-title">الرسائل الواردة</div>

                    <div class="message-item">
                        <div class="message-header">
                            <span class="message-date">اليوم 10:30</span>
                            <span class="message-sender">إدارة جمعية العلماء المسلمين</span>
                        </div>
                        <div class="message-content">
                            <p>نعلم الطلبة الأعزاء بتعديل جدول الحصص ليوم الخميس هذا الأسبوع. سيتم تقديم حصة التجويد إلى الساعة التاسعة صباحاً، ونرجو من الجميع الالتزام بالموعد الجديد.</p>
                        </div>
                    </div>

                    <div class="message-item">
                        <div class="message-header">
                            <span class="message-date">البارحة 14:15</span>
                            <span class="message-sender">الأستاذ عبد الرحمن مالك</span>
                        </div>
                        <div class="message-content">
                            <p>تم تصحيح اختبار الحفظ الأخير، يمكنك الاطلاع على النتيجة من خلال قسم العلامات. أحسنت على المجهود المبذول، واستمر في المراجعة المنتظمة.</p>
                        </div>
                    </div>

                    <div class="message-item">
                        <div class="message-header">
                            <span class="message-date">21/03/2025 09:45</span>
                            <span class="message-sender">إدارة جمعية العلماء المسلمين</span>
                        </div>
                        <div class="message-content">
                            <p>نذكر جميع الطلبة بضرورة التسجيل في المسابقة السنوية لحفظ القرآن الكريم، آخر موعد للتسجيل هو يوم الأحد القادم. يرجى التواصل مع سكرتارية المدرسة للمزيد من المعلومات.</p>
                        </div>
                    </div>

                    <div class="message-item">
                        <div class="message-header">
                            <span class="message-date">18/03/2025 16:20</span>
                            <span class="message-sender">الأستاذة نور الهدى</span>
                        </div>
                        <div class="message-content">
                            <p>أرجو منك مراجعة سورة البقرة الآيات من 150 إلى 200 قبل الحصة القادمة. سنقوم بتسميع هذه الآيات في بداية الحصة، كما سنتناول أحكام التجويد المتعلقة بها.</p>
                        </div>
                    </div>
                </div>

                <!-- الرسائل المرسلة -->
                <div class="messages-container" id="sent-content" style="display: none;">
                    <div class="section-title">الرسائل المرسلة</div>

                    <div class="message-item">
                        <div class="message-header">
                            <span class="message-date">22/03/2025 11:20</span>
                            <span class="message-sender">إلى: الأستاذ عبد الرحمن مالك</span>
                        </div>
                        <div class="message-content">
                            <p>السلام عليكم أستاذي الكريم، أرجو منكم تحديد موعد لمراجعة حفظي للجزء الأخير. أنا متاح يومي الثلاثاء والخميس بعد الساعة العاشرة صباحاً. جزاكم الله خيراً.</p>
                        </div>
                    </div>

                    <div class="message-item">
                        <div class="message-header">
                            <span class="message-date">15/03/2025 09:30</span>
                            <span class="message-sender">إلى: إدارة جمعية العلماء المسلمين</span>
                        </div>
                        <div class="message-content">
                            <p>السلام عليكم، أرجو إفادتي بموعد الاختبار النهائي للفصل الدراسي الحالي، وما هي المواد المطلوبة للاختبار. وشكراً جزيلاً.</p>
                        </div>
                    </div>
                </div>

                <!-- إنشاء رسالة جديدة -->
                <div class="compose-message" id="compose-content" style="display: none;">
                    <div class="section-title">إنشاء رسالة جديدة</div>

                    <form action="send_message.php" method="post">
                        <div class="form-group">
                            <label class="form-label">المرسل إليه:</label>
                            <select class="form-control" name="recipient" required>
                                <option value="">-- اختر المرسل إليه --</option>
                                <option value="admin">إدارة المدرسة</option>
                                <option value="teacher1">الأستاذ عبد الرحمن مالك</option>
                                <option value="teacher2">الأستاذة نور الهدى</option>
                                <option value="teacher3">الأستاذ محمد الصالح</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">الموضوع:</label>
                            <input type="text" class="form-control" name="subject" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">نص الرسالة:</label>
                            <textarea class="form-control" name="message" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">المرفقات (اختياري):</label>
                            <input type="file" class="form-control">
                        </div>

                        <button type="submit" class="send-btn">إرسال الرسالة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inboxTab = document.getElementById('inbox-tab');
            const sentTab = document.getElementById('sent-tab');
            const composeTab = document.getElementById('compose-tab');

            const inboxContent = document.getElementById('inbox-content');
            const sentContent = document.getElementById('sent-content');
            const composeContent = document.getElementById('compose-content');

            // التبديل بين التبويبات
            inboxTab.addEventListener('click', function() {
                inboxTab.classList.add('active');
                sentTab.classList.remove('active');
                composeTab.classList.remove('active');

                inboxContent.style.display = 'block';
                sentContent.style.display = 'none';
                composeContent.style.display = 'none';
            });

            sentTab.addEventListener('click', function() {
                sentTab.classList.add('active');
                inboxTab.classList.remove('active');
                composeTab.classList.remove('active');

                sentContent.style.display = 'block';
                inboxContent.style.display = 'none';
                composeContent.style.display = 'none';
            });

            composeTab.addEventListener('click', function() {
                composeTab.classList.add('active');
                inboxTab.classList.remove('active');
                sentTab.classList.remove('active');

                composeContent.style.display = 'block';
                inboxContent.style.display = 'none';
                sentContent.style.display = 'none';
            });
        });
    </script>
</body>

</html>