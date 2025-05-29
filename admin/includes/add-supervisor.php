<?php
//require_once __DIR__."/../classes/Student.php";
require_once __DIR__."/../../classes/DBConnection.php";

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
    'user' => '',
    'date' => '',
    'wilaya' => '',
    'address' => '',
    'gender' => '',
    'academic_level' => '',
    'employment_date' => '',
    'position' => ''
];

$first_name = $last_name = $email = $password = $confirm_password = $phone = $date_of_birth = $place_of_birth = $address = $gender = $academic_level = $position = $employment_date = $notes = ''; 


if($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $first_name = $_POST['first_name']; $last_name = $_POST['last_name']; $email = $_POST['email'];
        $password = $_POST['password']; $confirm_password = $_POST['confirm_password'];
        $date_of_birth = $_POST['date'];
        $place_of_birth = $_POST['wilaya']; 
        $phone= $_POST['phone']; $address = $_POST['address']; $gender = $_POST['gender']; $academic_level = $_POST['academic_level']; $employment_date = $_POST['employment_date']; $notes = $_POST['notes']; $position = $_POST['position'];
    if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($confirm_password) && !empty($phone) && !empty($date_of_birth) && !empty($place_of_birth) && !empty($address) && !empty($gender) && !empty($academic_level) && !empty($employment_date) && !empty($position) )
    {
        $first_name = filterString($first_name); 
        $last_name = filterString($last_name); 
        $email = filterEmail($email);
        $phone = filterString($phone);
        $date_of_birth = filterString($date_of_birth);
        $place_of_birth = filterString($place_of_birth);
        $address = filterString($address);
        $gender = filterString($gender);
        $academic_level = filterString($academic_level);
        $notes = filterString($notes);

        if(!$first_name)
            $errors['first_name']="الاسم غير صالح";
        if(!$last_name)
            $errors['last_name']="اللقب غير صالح";
        if(!$email)
            $errors['email']="الايميل غير صالح";
        if(!$phone)
            $errors['phone']="رقم الهاتف غير صالح";
        if(!$date_of_birth)
            $errors['date_of_birth']="تاريخ الميلاد غير صالح";
        if(!$place_of_birth)
            $errors['place_of_birth']="مكان الميلاد غير صالح";
        if(!$address)
            $errors['address']="العنوان غير صالح";
        if(!$gender)
            $errors['gender']="الجنس غير صالح";
        if(!$academic_level)
            $errors['academic_level']="المستوى الدراسي غير صالح";
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
        if(empty($_POST['phone'])) $errors['phone'] = "رقم الهاتف مطلوب";
        if(empty($_POST['date'])) $errors['date'] = "تاريخ الميلاد مطلوب";
        if(empty($_POST['wilaya'])) $errors['wilaya'] = "مكان الميلاد مطلوب";
        if(empty($_POST['address'])) $errors['address'] = "العنوان مطلوب";
        if(empty($_POST['gender'])) $errors['gender'] = "الجنس مطلوب";
        if(empty($_POST['academic_level'])) $errors['academic_level'] = "المستوى الدراسي مطلوب";
        if(empty($_POST['employment_date'])) $errors['employment_date'] = "تاريخ التوظيف مطلوب";
        if(empty($_POST['position'])) $errors['position']="تحديد الوظيفة مطلوب";
    }
   
    
    if(!$errors['first_name'] && !$errors['last_name'] && !$errors['email'] && !$errors['password'] && !$errors['confirm_password']  && !$errors['date'] && !$errors['wilaya'] && !$errors['address'] && !$errors['gender'] && !$errors['academic_level'] && !$errors['employment_date']) {
        $db = DBConnection::getConnection()->getDb();
        $query = $db->prepare("SELECT * FROM users WHERE email=?");
        $query->execute([$email]);
        if($query->fetch())
            $errors['user'] = "المستخدم موجود بالفعل";
        else {
            $password = password_hash($password,PASSWORD_DEFAULT);
            $db = DBConnection::getConnection()->getDb();
            
            // Insert into users table
            $query = $db->prepare("INSERT INTO users (email, first_name, last_name, password, gender, phone,date_of_birth,place_of_birth,address,academic_level, user_type) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?)");
            $query->execute([$email, $first_name, $last_name, $password, $gender, $phone,$date_of_birth,$place_of_birth,$address,$academic_level, 'admin']);
            $user_id = $db->lastInsertId();
            
            // Insert into students table
            $query = $db->prepare("INSERT INTO supervisors (user_id,employment_date,position ) VALUES (?, ?, ?)");
            $query->execute([
                $user_id,
                $employment_date,
                $position
            ]);
            
            header("Location: /quranic/admin/admin-users.php?user_type=admin");
            exit();
        }
    }
}