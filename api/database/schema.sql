-- Create database
CREATE DATABASE IF NOT EXISTS quranic_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quranic_db;

-- Teachers table
CREATE TABLE IF NOT EXISTS teachers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    status ENUM('active', 'pending', 'inactive') DEFAULT 'pending',
    join_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    circles_count INT DEFAULT 0
);

-- Students table
CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    status ENUM('active', 'pending', 'inactive') DEFAULT 'pending',
    join_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    circle_id INT,
    attendance_rate DECIMAL(5,2) DEFAULT 0.00
);

-- Study circles table
CREATE TABLE IF NOT EXISTS circles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    teacher_id INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
);

-- Attendance table
CREATE TABLE IF NOT EXISTS attendance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    circle_id INT,
    date DATE,
    status ENUM('present', 'absent', 'late') DEFAULT 'present',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (circle_id) REFERENCES circles(id)
);

-- Reports table
CREATE TABLE IF NOT EXISTS reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT,
    circle_id INT,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(id),
    FOREIGN KEY (circle_id) REFERENCES circles(id)
);

-- Student progress table
CREATE TABLE IF NOT EXISTS student_progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    surah_name VARCHAR(100),
    status ENUM('memorized', 'in_progress', 'not_started') DEFAULT 'not_started',
    last_review_date DATE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id)
); 