<?php
session_start();
require_once __DIR__."/../classes/Student.php";
require_once __DIR__."/../classes/DBConnection.php";

function filterString($field) 
{
    $field = filter_var(trim($field),FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($field))
        return false;
    else
        return $field;
}

function filterEmail($field) 
{
    $field = filter_var(trim($field),FILTER_SANITIZE_EMAIL);
    if(filter_var($field,FILTER_VALIDATE_EMAIL))
        return $field;
    else
        return false;
}

$errors = [
    'first_name' => '',
    'last_name' => '',
    'email' => '',
    'password' => '',
    'confirm_password' => '',
    'user' => ''
];

$email = $first_name = $last_name = $password = $confirm_password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) )
    {
        $first_name = filterString($_POST['first_name']); $last_name = filterString($_POST['last_name']); $email = filterEmail($_POST['email']);
        $password = $_POST['password']; $confirm_password = $_POST['confirm_password'];
        if(!$first_name)
            $errors['first_name']="first name is invalide";
        if(!$last_name)
            $errors['last_name']="last name is invalide";
        if(!$email)
            $errors['email']="Email is invalide";
        if(strlen($password) >= 8)
        {
            if($password != $confirm_password)
                $errors['confirm_password']="password don't match";
        }else {
            $errors['password']="password must at least 8 characters";
        }
        $password = password_hash($password,PASSWORD_DEFAULT);
    }else
    {
        if(empty($_POST['first_name'])) $errors['first_name'] = "your first name is required";
        if(empty($_POST['last_name'])) $errors['last_name'] = "your last name is required";
        if(empty($_POST['email'])) $errors['email'] = "your email is required";
        if(empty($_POST['password'])) $errors['first_name'] = "your password is required";
        if(empty($_POST['confirm_password'])) $errors['first_name'] = "Confirm password is required";
    }

    if(!$errors['first_name'] && !$errors['last_name'] && !$errors['email'] && !$errors['password'] && !$errors['confirm_password']) {
        $db = DBConnection::getConnection()->getDb();
        $query = $db->prepare("SELECT * FROM users WHERE email=?");
        $query->execute([$email]);
        if($query->fetch())
            $errors['user'] = "user already exist";
        else {
            $db = DBConnection::getConnection()->getDb();
            $student = new Student(
                $email,$password,$db,$first_name,$last_name,$_POST['gender']
            );
    
            $student->signup();
        
                $_SESSION['logen_in'] = true;
                $_SESSION['user_id'] = $db->lastInsertId();
                $_SESSION['user_name'] = $first_name;
                header("Location: /quranic/index.php");
                exit();
        }
    }
}