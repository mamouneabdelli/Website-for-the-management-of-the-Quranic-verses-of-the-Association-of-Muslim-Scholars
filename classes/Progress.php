<?php

class Progress {
    private $id;
    private $subject_id;
    private $group_id;
    private $student;
    private $db;

    public function __construct($group_id,$db)
    {
        $this->group_id = $group_id;
        $this->db = $db;
    }

    public function getProggresses()  {
        $query = $this->db->prepare("
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
            WHERE academic_progress.group_id = ? 
        ");
        $query->execute([$this->group_id]);
        $progresses = $query->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($progresses))
            return $progresses;
        else
            return [];
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