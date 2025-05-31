<?php
require_once __DIR__ . '/../classes/DBConnection.php';

function getScheduleData() {
    try {
        $db = DBConnection::getConnection()->getDb();
        
        $query = "SELECT 
                    c.id,
                    c.day,
                    c.start_time,
                    c.end_time,
                    c.class as room,
                    g.group_name as name,
                    s.name as subject_name,
                    CONCAT(u.first_name, ' ', u.last_name) as teacher_name,
                    t.id as teacher_id
                FROM curriculum c
                JOIN groups g ON c.group_id = g.id
                JOIN subjects s ON c.subject_id = s.id
                JOIN teachers t ON c.teacher_id = t.id
                JOIN users u ON t.user_id = u.id
                ORDER BY FIELD(c.day, 'السبت', 'الأحد', 'الإثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة'),
                         c.start_time";
        
        $stmt = $db->query($query);
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Map Arabic day names to English for data attributes
        $dayMap = [
            'السبت' => 'saturday',
            'الأحد' => 'sunday',
            'الإثنين' => 'monday',
            'الثلاثاء' => 'tuesday',
            'الأربعاء' => 'wednesday',
            'الخميس' => 'thursday',
            'الجمعة' => 'friday'
        ];
        
        // Map subject names to types for CSS classes
        $typeMap = [
            'القرأن الكريم' => 'quran',
            'التربية الاسلامية' => 'hadith',
            'لغة عربية' => 'fiqh',
            'سيرة نبوية' => 'tafsir'
        ];
        
        $formattedSessions = [];
        foreach ($sessions as $session) {
            $formattedSessions[] = [
                'id' => $session['id'],
                'day' => $dayMap[$session['day']],
                'time' => $session['start_time'],
                'name' => $session['name'],
                'teacher' => $session['teacher_name'],
                'room' => $session['room'],
                'type' => $typeMap[$session['subject_name']] ?? 'other',
                'teacher_id' => $session['teacher_id']
            ];
        }
        
        return $formattedSessions;
        
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}

// Output the data as JSON
header('Content-Type: application/json');
echo json_encode(getScheduleData());
?> 