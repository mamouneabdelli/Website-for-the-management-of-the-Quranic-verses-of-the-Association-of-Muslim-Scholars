<?php

require_once __DIR__ . "/User.php";

class Student extends User
{
    private $student_code;
    private $date_of_birth;
    private $place_of_birth;
    private $parent_name;
    private $parent_phone;
    private $academic_level;
    private $health_notes;
    private $enrollment_date;
    private $current_status;
    private $aditional_notes;
    private $academic_phase;
    private $db;

    public function __construct($email, $password, $db, $first_name = null, $last_name = null, $gender = null, $academic_phase = null)
    {
        parent::__construct($email, $password, $first_name, $last_name, $gender);
        $this->academic_phase = $academic_phase;
        $this->db = $db;
    }

    public function login()
    {
        try {
            $query = $this->db->prepare("SELECT * FROM users WHERE email=?");
            $query->execute([$this->email]);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($this->password, $user['password'])) {
                $query = $this->db->prepare("SELECT id FROM students WHERE user_id=?");
                $query->execute([$user['id']]);
                $user['student_id'] = $query->fetch();
                if ($user['student_id'])
                    return $user;
                else
                    return false;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("خطأ في تسجيل الدخول: " . $e->getMessage());
        }
    }

    public function signup()
    {
        try {
            $query = $this->db->prepare("INSERT INTO users (email, first_name, last_name, password, gender,user_type) VALUES (?, ?, ?, ?, ?,?)");
            $query->execute([$this->email, $this->first_name, $this->last_name, $this->password, $this->gender, 'student']);

            $user_id = $this->db->lastInsertId();

            $query = $this->db->prepare("INSERT INTO students (user_id,academic_phase) VALUES (?, ?)");
            $query->execute([$user_id, $this->academic_phase]);
            return true;
        } catch (PDOException $e) {
            die("خطأ في التسجيل: " . $e->getMessage());
        }
    }

    public static function getGroupId($studentId, $db)
    {
        $query = $db->prepare("SELECT group_id FROM student_groups WHERE student_id=?");
        $query->execute([$studentId]);
        $result =  $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result)
            return $result;
        else
            return "";
    }

    public static function getGrades($studentId, $db)
    {
        $query = $db->prepare("SELECT
            subjects.name as subject_name,
            grades.grade,
        grades.date,
        grades.status
            FROM grades 
            JOIN subjects ON subjects.id = grades.subject_id
            WHERE grades.student_id=? 
        ");
        $query->execute([$studentId]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public static function getMessages($groupId,$db) {
        $query = $db->prepare("SELECT * FROM messages WHERE group_id=? ORDER BY date DESC");
        $query->execute([$groupId]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
