<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['login_in'])) {
    $_SESSION['login_in'] = false;
    session_destroy();
    header("Location: /quranic/index.php");
    exit();
}
?>