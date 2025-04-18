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
           students.first_name,
           students.last_name,
           groups.name,
           academic_progress.sourah,
           academic_progress.ayah,
           academic_progress.evaluation,
           academic_progress.progress_type,
           academic_progress.date,
           academic_progress.note
           FROM academic_progress
           JOIN students ON  students.id = academic_progress.student_id
           JOIN groups ON  groups.id = academic_progress.group_id
            WHERE academic_progress.group_id = ? 
        ");
        $query->execute([$this->group_id]);
        $progresses = $query->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($progresses))
            return $progresses;
        else
            return false;
    }
}