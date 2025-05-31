<?php
require_once __DIR__ . '/../classes/DBConnection.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'بيانات غير صالحة']);
    exit;
}

// Convert English day names to Arabic
$dayMap = [
    'saturday' => 'السبت',
    'sunday' => 'الأحد',
    'monday' => 'الإثنين',
    'tuesday' => 'الثلاثاء',
    'wednesday' => 'الأربعاء',
    'thursday' => 'الخميس',
    'friday' => 'الجمعة'
];

// Get subject ID based on type
$subjectMap = [
    'quran' => 1, // القرآن الكريم
    'hadith' => 2, // التربية الاسلامية
    'fiqh' => 3, // لغة عربية
    'tafsir' => 4 // سيرة نبوية
];

try {
    $db = DBConnection::getConnection()->getDb();
    
    // التحقق من وجود الحلقة والحصول على معرف الأستاذ
    $groupQuery = "SELECT g.id, g.teacher_id FROM groups g WHERE g.id = :group_id";
    $groupStmt = $db->prepare($groupQuery);
    $groupStmt->execute([':group_id' => $data['group_id']]);
    $groupData = $groupStmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$groupData) {
        echo json_encode(['success' => false, 'message' => 'الحلقة غير موجودة']);
        exit;
    }
    
    // التحقق من تعارض المواعيد
    $checkQuery = "SELECT id FROM curriculum 
                  WHERE day = :day 
                  AND start_time = :start_time 
                  AND class = :class
                  AND group_id = :group_id";
    $checkStmt = $db->prepare($checkQuery);
    $checkStmt->execute([
        ':day' => $dayMap[$data['day']],
        ':start_time' => $data['start_time'],
        ':class' => $data['class'],
        ':group_id' => $data['group_id']
    ]);
    
    if ($checkStmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'هناك تعارض في الموعد والقاعة للحلقة']);
        exit;
    }
    
    // إضافة الموعد الجديد
    $insertQuery = "INSERT INTO curriculum (
                        day, 
                        start_time, 
                        end_time, 
                        class, 
                        teacher_id, 
                        subject_id, 
                        group_id
                    ) VALUES (
                        :day,
                        :start_time,
                        :end_time,
                        :class,
                        :teacher_id,
                        :subject_id,
                        :group_id
                    )";
    
    $insertStmt = $db->prepare($insertQuery);
    $result = $insertStmt->execute([
        ':day' => $dayMap[$data['day']],
        ':start_time' => $data['start_time'],
        ':end_time' => $data['end_time'],
        ':class' => $data['class'],
        ':teacher_id' => $groupData['teacher_id'],
        ':subject_id' => $data['subject_id'],
        ':group_id' => $data['group_id']
    ]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'تم إضافة الموعد بنجاح'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'حدث خطأ أثناء حفظ الموعد'
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'حدث خطأ في قاعدة البيانات'
    ]);
}
?> 