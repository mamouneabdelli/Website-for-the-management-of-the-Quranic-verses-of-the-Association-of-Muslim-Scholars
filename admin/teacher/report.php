<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Teacher.php';
require_once __DIR__ . '/../../classes/Progress.php';
require_once __DIR__ . '/../../classes/DBConnection.php';

$teacherId = 2;
$userId = 5;
$db = DBConnection::getConnection()->getDb();
$groupNames = Teacher::getGroups($teacherId, $db);

$emails = [];

foreach ($groupNames as $groupName) {
    $email = Teacher::getMessages($groupName['id'], $db);
    if (!empty($email)) {
        $emails[$groupName['id']] = $email; 
    }
}

$message = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['group']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $groupId = filter_var($_POST['group'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
        $senderId = $userId;

        $teacher = new Teacher($db);
        if ($teacher->sendReport($title, $content, $groupId, $senderId)) {
            $message = "تم ارسال الرسالة بنجاح";
        } else {
            $message = "خطأ في ارسال الرسالة";
        }
    } else {
        $message = "يجب ملء كل الحقول";
    }
}
?>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 60%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-btn:hover {
        color: black;
    }

    .message-content {
        margin-top: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .alert {
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 8px;
        font-size: 16px;
        text-align: center;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<link rel="stylesheet" href="css/report.css">

<div class="content">
    <!-- Message Section -->
    <div class="report-section" id="message-section">
        <?php if (!empty($message)): ?>
            <div class="alert <?= strpos($message, 'نجاح') !== false ? 'alert-success' : 'alert-error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="section-title">إرسال رسالة جديدة</div>

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            <div class="form-group">
                <label>المستلمون</label>
                <select class="form-control" name="group" >
                    <option value="" hidden>اختر الفوج</option>
                    <?php foreach ($groupNames as $groupName): ?>
                        <option value="<?= htmlspecialchars($groupName['id']) ?>"><?= htmlspecialchars($groupName['group_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>عنوان الرسالة</label>
                <input name="title" type="text" class="form-control" placeholder="أدخل عنوان الرسالة" >
            </div>

            <div class="form-group">
                <label>محتوى الرسالة</label>
                <textarea name="content" class="form-control" placeholder="اكتب محتوى الرسالة هنا" rows="6" ></textarea>
            </div>

            <div class="button-container">
                <button type="submit" class="message-btn">
                    <i class="fas fa-envelope"></i> إرسال الرسالة
                </button>
            </div>
            <div class="clearfix"></div>
        </form>
    </div>

    <!-- Previous Messages -->
    <div class="report-section previous-reports">
        <div class="section-title">الرسائل السابقة</div>

        <?php foreach ($emails as $groupId => $emailGroup): ?>
            <?php
            $groupName = array_filter($groupNames, fn($g) => $g['id'] == $groupId);
            $groupName = reset($groupName)['group_name'] ?? 'غير معروف';
            ?> ء
            <?php foreach ($emailGroup as $email): ?>
                <div class="report-card" data-content="<?= htmlspecialchars($email['content'] ?? '') ?>" data-group="<?= htmlspecialchars($groupName) ?>">
                    <div class="report-info">
                        <h4><?= htmlspecialchars($email['title']) ?></h4>
                        <p>تم الإرسال: <?= (new DateTime($email['date']))->format('d-m-Y \في H:i') ?></p>
                        <p>الى: <?= htmlspecialchars($groupName) ?></p>
                    </div>
                    <div class="report-actions">
                        <button class="view-btn"><i class="fas fa-eye"></i> عرض</button>
                        <button class="delete-btn"><i class="fas fa-trash"></i> حذف</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // Function to show message in a modal
    function showMessage(title, group, content) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <span class="close-btn">×</span>
                <h3>${title}</h3>
                <h4>إلى: ${group}</h4>
                <div class="message-content">${content}</div>
            </div>
        `;

        document.body.appendChild(modal);

        modal.querySelector('.close-btn').onclick = function() {
            modal.style.display = 'none';
            document.body.removeChild(modal);
        };

        modal.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.removeChild(modal);
            }
        };

        modal.style.display = 'block';
    }

    // Add event listeners for view buttons
    document.addEventListener('DOMContentLoaded', function() {
        const viewButtons = document.querySelectorAll('.view-btn');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const reportCard = this.closest('.report-card');
                const title = reportCard.querySelector('h4').textContent;
                const group = reportCard.dataset.group;
                const content = reportCard.dataset.content;

                showMessage(title, group, content);
            });
        });
    });
</script>

</body>
</html>