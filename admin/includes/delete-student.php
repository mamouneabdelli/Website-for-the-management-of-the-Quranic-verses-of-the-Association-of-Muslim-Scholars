<?php

if(isset($_POST['user_id']) && $_POST['delete_type'] == "student") {
    $user_id = $_POST['user_id'];
    $db = DBConnection::getConnection()->getDb();
    $query = $db->prepare("DELETE FROM students WHERE user_id=?");
    $query->execute([$user_id]);

    $query = $db->prepare("DELETE FROM users WHERE id=?");
    $query->execute([$user_id]);

    header("Location: /quranic/admin/admin-users.php?user_type=student");

}
 ?>