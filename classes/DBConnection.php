<?php

require_once __DIR__.'/../config/database.php';

class DBConnection {
    private static $instance = null;
    private $db;

    private function __construct()
    {
        global $config; 
        try {
            $this->db = new PDO(
                "mysql:host={$config['host']};dbname={$config['database']}",
                $config['user'],
                $config['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to database: " . $e->getMessage());
        }
    }

    public static function getConnection() {
        if (self::$instance === null) {
            self::$instance = new DBConnection();
        }
        return self::$instance;
    }

    public function getDb() {
        return $this->db;
    }
}