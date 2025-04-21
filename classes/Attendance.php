<?php

class Attendance
{
    private $id;
    private $date;
    private $status;
    private $reason_of_absence;
    private $is_excused;
    private $user_id;
    private $group_id;
    private $db;

    public function __construct($group_id, $db)
    {
        $this->group_id = $group_id;
        $this->db = $db;
    }

    public function getAttendance()
    {
        try {
            $query = $this->db->prepare("
            SELECT 
                users.first_name,
                users.last_name, 
                students.parent_phone, 
                students.id, 
                attendance.status, 
                attendance.date, 
                attendance.note,
                groups.group_name
            FROM attendance
            JOIN students ON students.id = attendance.student_id
            JOIN users ON users.id = students.user_id
            JOIN groups ON groups.id = attendance.group_id
            WHERE attendance.group_id = ? ORDER BY attendance.id ASC
        ");
            $query->execute([$this->group_id]);
            $user = $query->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            die("Error" . $e->getMessage());
        }
    }

    public function getStudents() {
        $query = $this->db->prepare("
            SELECT 
              users.first_name ,
              users.last_name ,
              students.id
            FROM student_groups
            JOIN students ON students.id = student_groups.student_id
            JOIN users ON users.id = students.user_id
            WHERE student_groups.group_id = ?   
        ");

        $query->execute([$this->group_id]);

        $groupNames = $query->fetchAll(PDO::FETCH_ASSOC);

        if(empty($groupNames))
            return "";
        else
            return $groupNames;
    }
}
