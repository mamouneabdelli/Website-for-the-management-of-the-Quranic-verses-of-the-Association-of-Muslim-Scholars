<?php

require_once __DIR__.'/../template/header.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Student.php';


$studentId = $_SESSION['student_id']['id'];
$db = DBConnection::getConnection()->getDb();
$userId = $_SESSION['user_id'];

$groupId = Student::getGroupId(
    $studentId,
    $db
);

if(isset($_GET['id'])) {
    $query = $db->prepare("SELECT * FROM messages WHERE user_id=? ORDER BY date DESC");
        $query->execute([$userId]);
        $messages = $query->fetchAll(PDO::FETCH_ASSOC);

}else {
if (!empty($groupId[0]['group_id']))
    $messages = Student::getMessages($groupId[0]['group_id'], $db);

}
?>

                <!-- الرسائل والمحادثات -->
                <div class="messages-tab">
                    <a class="tab-btn <?= isset($_GET['id']) ? " " : "active" ?> " id="inbox-tab" href="messages.php">صندوق الوارد</a>
                    <a class="tab-btn <?= isset($_GET['id']) ? "active" : "" ?>" id="sent-tab" href="?id=<?= $studentId ?>">الرسائل المرسلة</a>
                    <button class="tab-btn" id="compose-tab">إنشاء رسالة جديدة</button>
                </div>

                <!-- صندوق الوارد -->
                <div class="messages-container" id="inbox-content">
                    <div class="section-title"><?php if(isset($_GET['id'])) { ?>الرسائل المرسلة<?php }else{ ?>الرساءل الواردة<?php }?></div>

                                <?php
                        if (!empty($messages)) {
                            foreach ($messages as $message) { ?>
                                <div style="background-color: #f8f8f8; padding: 15px; border-radius: 8px; margin-bottom: 10px; border-right: 4px solid #27ae60;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                        <span style="color: #777; font-size: 12px;"><?= $message['date'] ?></span>
                                        <strong><?= $message['sender'] ?></strong>
                                    </div>
                                    <p><?= $message['content'] ?></p>
                                </div>
                            <?php }
                        } else {
                            ?>
                            لاتوجد رسائل
                        <?php } ?>
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
                
            </div>
        </div>
    </div>

    
</body>

</html>