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

    public function login($user)
    {
        try {
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
        $query = $db->prepare("
    SELECT student_groups.group_id, groups.group_name 
    FROM student_groups
    JOIN groups ON groups.id = student_groups.group_id
    WHERE student_groups.student_id = ?
");
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

    public static function getProggresses($studentId,$db)  {
        $query = $db->prepare("
           SELECT 
           users.first_name,
           users.last_name,
           groups.group_name,
           academic_progress.sourah,
           academic_progress.ayah,
           academic_progress.evaluation,
           academic_progress.progress_type,
           academic_progress.date,
           academic_progress.note
           FROM academic_progress
           JOIN students ON  students.id = academic_progress.student_id
           JOIN users ON  users.id = students.user_id
           JOIN groups ON  groups.id = academic_progress.group_id
            WHERE academic_progress.student_id = ? 
        ");
        $query->execute([$studentId]);
        $progresses = $query->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($progresses))
            return $progresses;
        else
            return [];
    }
}
