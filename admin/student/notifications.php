<?php

require_once __DIR__ . '/../template/header.php';
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Student.php';


$studentId = $_SESSION['studen_id']['id'];
$db = DBConnection::getConnection()->getDb();


$groupId = Student::getGroupId(
    $studentId,
    $db
);

$messages = Student::getMessages($groupId[0]['group_id'], $db);


?>

<!-- Notifications Section -->
<div class="full-width-container">
    <div class="schedule-section">
        <div class="schedule-title">الاشعارات <span>الرسائل الجديدة</span></div>
        <div style="padding: 10px;">
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
</div>


<?php

require_once __DIR__ . '/../template/footer.php';

?>