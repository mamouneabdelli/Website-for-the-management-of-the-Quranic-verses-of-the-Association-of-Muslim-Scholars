<?php
ob_start();

$ac_session = "active";
require_once __DIR__ .'/template/header.php';

if (!isset($_GET['id'])) {
    header("Location: admin-sessions.php");
    exit;
}

$group_id = $_GET['id'];

try {
    $db->beginTransaction();
    
    // Check if group has active students
    $check_students = $db->prepare("
        SELECT COUNT(*) as student_count 
        FROM student_groups 
        WHERE group_id = ? AND status = 'active'
    ");
    $check_students->execute([$group_id]);
    $student_count = $check_students->fetch(PDO::FETCH_ASSOC)['student_count'];
    
    if ($student_count > 0) {
        $_SESSION['error'] = "لا يمكن حذف الحلقة لوجود طلاب نشطين فيها";
        header("Location: admin-sessions.php");
        exit;
    }
    
    // Delete curriculum entries
    $delete_curriculum = $db->prepare("DELETE FROM curriculum WHERE group_id = ?");
    $delete_curriculum->execute([$group_id]);
    
    // Delete attendance records
    $delete_attendance = $db->prepare("DELETE FROM attendance WHERE group_id = ?");
    $delete_attendance->execute([$group_id]);
    
    // Delete academic progress records
    $delete_progress = $db->prepare("DELETE FROM academic_progress WHERE group_id = ?");
    $delete_progress->execute([$group_id]);
    
    // Update students' registration status to 0 BEFORE deleting their group associations
    try {
        $update_students = $db->prepare("
            UPDATE students s 
            INNER JOIN student_groups sg ON s.id = sg.student_id 
            SET s.registered = 0 
            WHERE sg.group_id = ?
        ");
        $result = $update_students->execute([$group_id]);
        
        if (!$result) {
            error_log("Failed to update students registration status: " . print_r($update_students->errorInfo(), true));
        }
        
        // Log the number of affected rows
        error_log("Number of students updated: " . $update_students->rowCount());
    } catch (PDOException $e) {
        error_log("Error updating students: " . $e->getMessage());
        throw $e;
    }
    
    // Delete student group associations
    $delete_student_groups = $db->prepare("DELETE FROM student_groups WHERE group_id = ?");
    $delete_student_groups->execute([$group_id]);
    
    // Delete group subjects
    $delete_group_subjects = $db->prepare("DELETE FROM group_subjects WHERE group_id = ?");
    $delete_group_subjects->execute([$group_id]);
    
    // Delete messages
    $delete_messages = $db->prepare("DELETE FROM messages WHERE group_id = ?");
    $delete_messages->execute([$group_id]);
    
    // Finally, delete the group
    $delete_group = $db->prepare("DELETE FROM groups WHERE id = ?");
    $delete_group->execute([$group_id]);
    
    $db->commit();
    $_SESSION['success'] = "تم حذف الحلقة بنجاح";
} catch (Exception $e) {
    $db->rollBack();
    $_SESSION['error'] = "حدث خطأ أثناء حذف الحلقة: " . $e->getMessage();
}

header("Location: admin-sessions.php");
exit; 

ob_end_flush();