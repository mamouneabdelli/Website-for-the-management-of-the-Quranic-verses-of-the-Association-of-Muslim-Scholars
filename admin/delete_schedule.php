<?php
require_once __DIR__ . '/../classes/DBConnection.php';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'معرف الموعد مطلوب']);
    exit;
}

try {
    $db = DBConnection::getConnection()->getDb();
    
    // حذف الموعد
    $deleteQuery = "DELETE FROM curriculum WHERE id = :id";
    $deleteStmt = $db->prepare($deleteQuery);
    $result = $deleteStmt->execute([':id' => $data['id']]);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'تم حذف الموعد بنجاح'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'حدث خطأ أثناء حذف الموعد'
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'حدث خطأ في قاعدة البيانات'
    ]);
} 