<?php

session_start();

if(isset($_SESSION['login_in'])) {
    $_SESSION = [];
    header("Location: http://localhost/quranic");
    exit();
}

?>