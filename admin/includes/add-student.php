<?php
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

$email = $first_name = $last_name = $password = $confirm_password = $date_of_birth = $place_of_birth = $phone = $address = $notes = '';


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $first_name = $_POST['first_name']; $last_name = $_POST['last_name']; $email = $_POST['email'];
        $password = $_POST['password']; $confirm_password = $_POST['confirm_password'];
        $date_of_birth = $_POST['date'];
        $place_of_birth = $_POST['wilaya'];
    if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['phone']) && !empty($_POST['date']) && !empty($_POST['wilaya']) && !empty($_POST['address']) && !empty($_POST['gender']) && !empty($_POST['notes']) )
    {
        $first_name = filterString($first_name); $last_name = filterString($last_name); $email = filterEmail($email);
        if(!$first_name)
            $errors['first_name']="الاسم غير صالح";
        if(!$last_name)
            $errors['last_name']="اللقب غير صالح";
        if(!$email)
            $errors['email']="الايميل غير صالح";
        if(strlen($password) >= 8)
        {
            if($password != $confirm_password)
                $errors['confirm_password']="كلمة السر غير متطابقة";
        }else {
            $errors['password']="كلمة السر يجب ان تكون على الأقل 8 أحرف";
        }
    }else
    {
        if(empty($_POST['first_name'])) $errors['first_name'] = "الاسم مطلوب";
        if(empty($_POST['last_name'])) $errors['last_name'] = "اللقب مطلوب";
        if(empty($_POST['email'])) $errors['email'] = "الاميل مطلوب";
        if(empty($_POST['password'])) $errors['password'] = "كلمة السر مطلوبة";
        if(empty($_POST['confirm_password'])) $errors['confirm_password'] = "تأكيد كلمة السر مطلوبة";
    }

    if(!$errors['first_name'] && !$errors['last_name'] && !$errors['email'] && !$errors['password'] && !$errors['confirm_password']) {
        $db = DBConnection::getConnection()->getDb();
        $query = $db->prepare("SELECT * FROM users WHERE email=?");
        $query->execute([$email]);
        if($query->fetch())
            $errors['user'] = "المستخدم موجود بالفعل";
        else {
            $password = password_hash($password,PASSWORD_DEFAULT);
            $db = DBConnection::getConnection()->getDb();
            $student = new Student(
                $email,$password,$db,$first_name,$last_name,$_POST['gender'],$_POST['academic_phase']
            );
    
            $student->signup();
                header("Location: /quranic/index.php");
                exit();
        }
    }
}