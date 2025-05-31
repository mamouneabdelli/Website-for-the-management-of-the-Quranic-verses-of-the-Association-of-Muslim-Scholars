<?php
require_once __DIR__ . '/../classes/DBConnection.php';

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'معرف الموعد مطلوب']);
    exit;
}

try {
    $db = DBConnection::getConnection()->getDb();
    
    $query = "SELECT 
                c.id,
                c.day,
                c.start_time,
                c.end_time,
                c.class,
                c.group_id,
                c.subject_id,
                g.group_name,
                s.name as subject_name,
                CONCAT(u.first_name, ' ', u.last_name) as teacher_name
            FROM curriculum c
            JOIN groups g ON c.group_id = g.id
            JOIN subjects s ON c.subject_id = s.id
            JOIN teachers t ON c.teacher_id = t.id
            JOIN users u ON t.user_id = u.id
            WHERE c.id = :id";
    
    $stmt = $db->prepare($query);
    $stmt->execute([':id' => $_GET['id']]);
    $schedule = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($schedule) {
        // Convert Arabic day to English for the form
        $dayMap = [
            'السبت' => 'saturday',
            'الأحد' => 'sunday',
            'الإثنين' => 'monday',
            'الثلاثاء' => 'tuesday',
            'الأربعاء' => 'wednesday',
            'الخميس' => 'thursday',
            'الجمعة' => 'friday'
        ];
        
        $schedule['day'] = $dayMap[$schedule['day']];
        
        echo json_encode([
            'success' => true,
            'schedule' => $schedule
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'الموعد غير موجود'
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'حدث خطأ في قاعدة البيانات'
    ]);
} 