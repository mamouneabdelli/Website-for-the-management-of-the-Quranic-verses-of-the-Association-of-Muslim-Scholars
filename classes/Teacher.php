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
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }

    public function login($user) {

    }

    public function signup()
    {
        
    }

    public function setAbsence() {
        
    }

    public function removeAbsence() {
        
    }

    public function sendReport($title, $content, $groupId, $senderId) {
        try {
            $query = $this->db->prepare("
                INSERT INTO messages (title, content, group_id, sender_id)
                VALUES (?, ?, ?, ?)
            ");
            $query->execute([$title, $content, $groupId, $senderId]);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    

    public function setGrades() {
        
    }

    public static function getGroups($teacherId, $db)
    {

        $query = $db->prepare("
        SELECT id FROM groups WHERE teacher_id = ?
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
    
    public static function getMessages($groupId,$db) {
        $query = $db->prepare("
        SELECT 
        messages.title,
        messages.content,
        messages.date,
        users.first_name,
        users.last_name 
        FROM messages
        JOIN users ON users.id = messages.sender_id 
        WHERE group_id=? ORDER BY date DESC
        ");
        $query->execute([$groupId]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}