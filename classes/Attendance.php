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

    public function __construct($user_id, $db)
    {
        $this->user_id = $user_id;
        $this->db = $db;
    }

    public function getAttendance()
    {
        try {
            $query = $this->db->prepare("SELECT * FROM attendance WHERE user_id=?");
            $query->execute([$this->user_id]);
            $user = $query->fetchAll(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            die("Error" . $e->getMessage());
        }
    }
}
