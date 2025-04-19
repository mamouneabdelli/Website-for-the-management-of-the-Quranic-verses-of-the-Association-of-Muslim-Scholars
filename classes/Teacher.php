<?php

class Teacher extends User implements Report {
    private $teacher_code;
    private $date_of_birth;
    private $specialization;
    private $qualification;
    private $enrollment_date;
    private $address;
    private $academic_level;
    private $notes;

    public function login() {

    }

    public function signup()
    {
        
    }

    public function setAbsence() {
        
    }

    public function removeAbsence() {
        
    }

    public function sendReport() {
        
    }

    public function setGrades() {
        
    }

    public static function getGroups($teacherId, $db)
    {

        $query = $db->prepare("
        SELECT group_id FROM group_teachers WHERE teacher_id = ?
    ");
        $query->execute([$teacherId]);
        $groupIds = $query->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($groupIds)) {
            $placeholders = implode(',', array_fill(0, count($groupIds), '?'));

            $query = $db->prepare("
            SELECT group_name , id FROM groups WHERE id IN ($placeholders)
        ");
            $query->execute($groupIds);
            $groupNames = $query->fetchAll(PDO::FETCH_ASSOC);

            return !empty($groupNames) ? $groupNames : false;
        }

        return false;
    }

}