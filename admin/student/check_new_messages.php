<?php
session_start();
require_once __DIR__ . '/../../classes/DBConnection.php';
require_once __DIR__ . '/../../classes/Student.php';
require_once __DIR__ . '/../../classes/Report.php';
require_once __DIR__ . '/../../classes/Teacher.php';

header('Content-Type: application/json');

try {
    if (!isset($_SESSION['student_id']['id'])) {
        throw new Exception('Student ID not found in session');
    }

    $studentId = $_SESSION['student_id']['id'];
    $db = DBConnection::getConnection()->getDb();
    $groupId = Student::getGroupId($studentId, $db);

    if (empty($groupId)) {
        throw new Exception('Group ID not found');
    }

    $messages = Teacher::getMessages($groupId[0]['group_id'], $db);

    echo json_encode([
        'success' => true,
        'message_count' => count($messages)
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?>
