<?php

ob_start();


$ac_message = "active";
require_once __DIR__ .'/template/header.php';
require_once __DIR__ . '/../classes/DBConnection.php';
require_once __DIR__ . '/../classes/Report.php';
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/Teacher.php';

$db = DBConnection::getConnection()->getDb();

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'send') {
    if (!empty($_POST['groupId']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $teacher = new Teacher($db);
        $result = $teacher->sendReport(
            $_POST['title'],
            $_POST['content'],
            $_POST['groupId'],
            $_SESSION['user_id']
        );
        
        if ($result) {
            $_SESSION['success'] = "تم إرسال الرسالة بنجاح";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء إرسال الرسالة";
        }
    } else {
        $_SESSION['error'] = "يرجى ملء جميع الحقول المطلوبة";
    }
    header("Location: admin-reports.php");
    exit;
}

// Handle message deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (!empty($_POST['message_id'])) {
        $query = $db->prepare("DELETE FROM messages WHERE id = ?");
        $result = $query->execute([$_POST['message_id']]);
        
        if ($result) {
            $_SESSION['success'] = "تم حذف الرسالة بنجاح";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء حذف الرسالة";
        }
    }
    header("Location: admin-reports.php");
    exit;
}

// Fetch all groups
$query = $db->prepare("
    SELECT g.id, g.group_name, u.first_name, u.last_name 
    FROM groups g 
    JOIN teachers t ON g.teacher_id = t.id 
    JOIN users u ON t.user_id = u.id
");
$query->execute();
$groups = $query->fetchAll(PDO::FETCH_ASSOC);

// Fetch all messages
$query = $db->prepare("
    SELECT m.*, u.first_name, u.last_name, g.group_name
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    JOIN groups g ON m.group_id = g.id
    ORDER BY m.date DESC
");
$query->execute();
$messages = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="CSS/admin-reports.css">

        <div class="content">
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'] ?>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="search-bar">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="بحث عن تقرير أو رسالة...">
                </div>
                <button class="add-btn" id="openSendMessageModal">
                    <i class="fas fa-plus"></i> إرسال رسالة جديدة
                </button>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="number green"><?= count($messages) ?></div>
                    <div class="label">الرسائل المرسلة</div>
                </div>
            </div>

            <div class="filter-section">
                <div class="filter-title">تصفية النتائج</div>
                <div class="filter-options">
                    <div class="filter-option">
                        <label>التاريخ:</label>
                        <select class="filter-select" id="dateFilter">
                            <option value="all">الكل</option>
                            <option value="today">اليوم</option>
                            <option value="week">هذا الأسبوع</option>
                            <option value="month">هذا الشهر</option>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>المرسل/المتلقي:</label>
                        <select class="filter-select" id="senderFilter">
                            <option value="all">الكل</option>
                            <?php foreach ($groups as $group): ?>
                            <option value="<?= $group['id'] ?>"><?= $group['group_name'] ?> - أ. <?= $group['first_name'] . ' ' . $group['last_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-option">
                        <label>الترتيب:</label>
                        <select class="filter-select" id="sortFilter">
                            <option value="newest">الأحدث</option>
                            <option value="oldest">الأقدم</option>
                            <option value="title">العنوان</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="admin-section">
                <div class="section-title">
                    قائمة الرسائل
                    <span>إجمالي: <?= count($messages) ?> عنصر</span>
                </div>

                <div class="tabs">
                    <div class="tab active">الكل</div>
                </div>

                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>العنوان</th>
                            <th>النوع</th>
                            <th>المرسل/المتلقي</th>
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?= htmlspecialchars($message['title']) ?></td>
                            <td>رسالة</td>
                            <td><?= htmlspecialchars($message['group_name']) ?></td>
                            <td><?= (new DateTime($message['date']))->format('d-m-Y') ?></td>
                            <td><span class="status status-active">مرسلة</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-button view" data-message="<?= htmlspecialchars($message['content'], ENT_QUOTES) ?>">
                                        <i class="fas fa-eye"></i> عرض
                                    </button>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                        <button type="submit" class="action-button delete" onclick="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Send Message Modal -->
    <div class="modal" id="sendMessageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">إرسال رسالة جديدة</div>
                <button class="close-btn" id="closeSendMessageModal">×</button>
            </div>
            <form id="sendMessageForm" method="post">
                <input type="hidden" name="action" value="send">
                <div class="form-group">
                    <label class="form-label">المستلم</label>
                    <select class="form-input" name="groupId" required>
                        <option value="">اختر المستلم</option>
                        <?php foreach ($groups as $group): ?>
                        <option value="<?= $group['id'] ?>"><?= $group['group_name'] ?> - أ. <?= $group['first_name'] . ' ' . $group['last_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">عنوان الرسالة</label>
                    <input type="text" class="form-input" name="title" required>
                </div>
                <div class="form-group">
                    <label class="form-label">محتوى الرسالة</label>
                    <textarea class="form-input" name="content" rows="6" required></textarea>
                </div>
                <button type="submit" class="form-submit">إرسال الرسالة</button>
            </form>
        </div>
    </div>

    <!-- View Message Modal -->
    <div class="modal" id="viewMessageModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">تفاصيل الرسالة</div>
                <button class="close-btn" id="closeViewMessageModal">×</button>
            </div>
            <div class="modal-body">
                <p id="messageContent"></p>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        const openSendMessageModal = document.getElementById('openSendMessageModal');
        const closeSendMessageModal = document.getElementById('closeSendMessageModal');
        const sendMessageModal = document.getElementById('sendMessageModal');
        const viewMessageModal = document.getElementById('viewMessageModal');
        const closeViewMessageModal = document.getElementById('closeViewMessageModal');
        const messageContent = document.getElementById('messageContent');

        openSendMessageModal.addEventListener('click', function() {
            sendMessageModal.style.display = 'flex';
        });

        closeSendMessageModal.addEventListener('click', function() {
            sendMessageModal.style.display = 'none';
        });

        closeViewMessageModal.addEventListener('click', function() {
            viewMessageModal.style.display = 'none';
        });

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target === sendMessageModal) {
                sendMessageModal.style.display = 'none';
            }
            if (event.target === viewMessageModal) {
                viewMessageModal.style.display = 'none';
            }
        });

        // Handle view message
        document.querySelectorAll('.action-button.view').forEach(button => {
            button.addEventListener('click', () => {
                messageContent.textContent = button.getAttribute('data-message');
                viewMessageModal.style.display = 'flex';
            });
        });

        // Handle filters
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', () => {
                // Implement filtering logic here
                console.log('Filter changed:', select.id, select.value);
            });
        });
    </script>
</body>
</html>


<?php
ob_end_flush();

?>