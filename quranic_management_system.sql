-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2025 at 01:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quranic_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_progress`
--

CREATE TABLE `academic_progress` (
  `id` int(11) UNSIGNED NOT NULL,
  `student_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `sourah` varchar(128) NOT NULL,
  `ayah` varchar(128) NOT NULL,
  `evaluation` enum('ممتاز','جيد','متوسط','يحتاج مراجعة') NOT NULL,
  `progress_type` enum('حفظ جديد','مراجعة','','') NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_progress`
--

INSERT INTO `academic_progress` (`id`, `student_id`, `group_id`, `sourah`, `ayah`, `evaluation`, `progress_type`, `date`, `note`) VALUES
(4, 2, 2, ' الملك', '1-30', 'جيد', 'مراجعة', '2025-04-19', 'الاحكام غير متقنة'),
(5, 5, 2, 'القلم', '1-40', 'متوسط', 'حفظ جديد', '2025-04-19', 'الكثير من الاخطاء'),
(6, 6, 2, 'البينة', 'كاملة', 'يحتاج مراجعة', 'حفظ جديد', '2025-04-19', 'عليه بالتكرار'),
(7, 5, 2, 'الأنعام', '20-100', 'ممتاز', 'حفظ جديد', '2025-04-24', 'جيد');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `admin_code` varchar(20) NOT NULL,
  `date_of_birth` date NOT NULL,
  `employment_date` date DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `responsibilities` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) UNSIGNED NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('حاضر','غائب','متأخر') NOT NULL,
  `note` text DEFAULT NULL,
  `is_excused` tinyint(1) DEFAULT NULL,
  `student_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `date`, `status`, `note`, `is_excused`, `student_id`, `group_id`, `created_by`) VALUES
(19, '2025-04-20', 'حاضر', NULL, NULL, 2, 2, 2),
(20, '2025-04-20', 'غائب', NULL, NULL, 5, 2, 2),
(21, '2025-04-20', 'متأخر', NULL, NULL, 6, 2, 2),
(22, '2025-04-17', 'حاضر', NULL, NULL, 2, 2, 2),
(23, '2025-04-17', 'غائب', NULL, NULL, 5, 2, 2),
(24, '2025-04-17', 'غائب', NULL, NULL, 6, 2, 2),
(25, '2025-04-07', 'حاضر', NULL, NULL, 2, 2, 2),
(26, '2025-04-07', 'حاضر', NULL, NULL, 5, 2, 2),
(27, '2025-04-07', 'حاضر', NULL, NULL, 6, 2, 2),
(28, '2025-04-04', 'حاضر', NULL, NULL, 2, 2, 2),
(29, '2025-04-04', 'حاضر', NULL, NULL, 5, 2, 2),
(30, '2025-04-04', 'حاضر', NULL, NULL, 6, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `curriculum`
--

CREATE TABLE `curriculum` (
  `id` int(11) UNSIGNED NOT NULL,
  `day` enum('الأحد','الإثنين','الثلاثاء','الأربعاء','الخميس','الجمعة','السبت') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `class` varchar(128) NOT NULL,
  `teacher_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `curriculum`
--

INSERT INTO `curriculum` (`id`, `day`, `start_time`, `end_time`, `class`, `teacher_id`, `subject_id`, `group_id`) VALUES
(1, 'الأحد', '02:00:00', '04:00:00', 'القاعة 1', 2, 1, 2),
(2, 'الإثنين', '06:30:00', '08:30:00', 'القاعة 2', 2, 7, 2),
(3, 'الثلاثاء', '02:00:00', '04:00:00', 'القاعة 1', 2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`) VALUES
(1, 'الأحد'),
(4, 'الأربعاء'),
(2, 'الاثنين'),
(3, 'الثلاثاء'),
(6, 'الجمعة'),
(5, 'الخميس'),
(7, 'السبت');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int(11) NOT NULL,
  `student_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `grade` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('ناجح','راسب','غياب') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject_id`, `grade`, `date`, `status`) VALUES
(1, 2, 6, 80, '2025-04-18 10:53:50', 'ناجح'),
(2, 2, 5, 40, '2025-04-18 10:54:18', 'راسب'),
(3, 2, 4, NULL, '2025-04-18 11:06:05', 'غياب');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_name` varchar(128) NOT NULL,
  `group_type_id` int(11) UNSIGNED NOT NULL,
  `capacity` int(11) DEFAULT NULL,
  `academic_year` varchar(10) DEFAULT NULL,
  `semester` enum('first','second','summer') DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `group_type_id`, `capacity`, `academic_year`, `semester`, `start_date`, `end_date`, `description`) VALUES
(2, 'قرأن(رجال) الفوج 1', 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_subjects`
--

CREATE TABLE `group_subjects` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `curriculum_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_teachers`
--

CREATE TABLE `group_teachers` (
  `id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `teacher_id` int(11) UNSIGNED NOT NULL,
  `assigned_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_teachers`
--

INSERT INTO `group_teachers` (`id`, `group_id`, `teacher_id`, `assigned_date`) VALUES
(2, 2, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `group_types`
--

CREATE TABLE `group_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_types`
--

INSERT INTO `group_types` (`id`, `type_name`, `description`) VALUES
(1, 'تحضيري', NULL),
(2, 'تمهيدي', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `group_id` int(11) UNSIGNED NOT NULL,
  `sender_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `title`, `content`, `date`, `group_id`, `sender_id`) VALUES
(2, 'لاتوجد دراسة غدا', 'نعلم طلابنا الأعزاء بأنني غائب غدا لأسباب صحية', '2025-04-22 13:29:07', 2, 5),
(3, 'يوجد امتحان غدا', 'نعلم طلابنا الأعزاء ان هناك امتحان غدا في الحزب الأول', '2025-04-22 14:50:44', 2, 5),
(4, 'يوجد امتحان غدا', 'نعلم طلابنا الأعزاء ان هناك امتحان غدا في الحزب الأول', '2025-04-22 14:52:58', 2, 5),
(18, 'اعلان', 'المسابقة ستكون الأسبوع القادم', '2025-04-23 23:03:31', 2, 5),
(19, 'صحا عيدكم', 'السلام عليكم', '2025-05-04 09:58:57', 2, 5),
(20, 'حنوس نقش', 'النقطة تاعك زيرو', '2025-05-14 13:32:12', 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `periods`
--

CREATE TABLE `periods` (
  `id` int(11) UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `label` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periods`
--

INSERT INTO `periods` (`id`, `start_time`, `end_time`, `label`) VALUES
(1, '08:00:00', '08:15:00', NULL),
(2, '08:15:00', '09:00:00', NULL),
(3, '09:00:00', '09:30:00', NULL),
(4, '09:30:00', '09:40:00', NULL),
(5, '09:40:00', '10:30:00', NULL),
(6, '10:30:00', '11:00:00', NULL),
(7, '11:00:00', '12:00:00', NULL),
(8, '16:30:00', '18:30:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) UNSIGNED NOT NULL,
  `day_id` int(11) UNSIGNED NOT NULL,
  `period_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `academic_phase` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `place_of_birth` varchar(50) DEFAULT NULL,
  `parent_name` varchar(128) DEFAULT NULL,
  `parent_phone` varchar(20) DEFAULT NULL,
  `parent_email` varchar(128) DEFAULT NULL,
  `academic_level` varchar(50) DEFAULT NULL,
  `health_notes` text DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `additional_notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `academic_phase`, `date_of_birth`, `place_of_birth`, `parent_name`, `parent_phone`, `parent_email`, `academic_level`, `health_notes`, `enrollment_date`, `address`, `additional_notes`) VALUES
(2, 3, 'university', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 6, 'university', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 7, 'university', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 10, 'secondary', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 11, 'middle', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_groups`
--

CREATE TABLE `student_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `student_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `enrollment_date` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','withdrawn','completed') DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_groups`
--

INSERT INTO `student_groups` (`id`, `student_id`, `group_id`, `enrollment_date`, `status`, `notes`) VALUES
(2, 2, 2, '2025-04-18', NULL, NULL),
(3, 5, 2, '2025-04-18', NULL, NULL),
(4, 6, 2, '2025-04-19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  `credits` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `level`, `credits`) VALUES
(1, 'القرأن الكريم', NULL, NULL),
(2, 'التربية الاسلامية', NULL, NULL),
(3, 'لغة عربية', NULL, NULL),
(4, 'سيرة نبوية', NULL, NULL),
(5, 'رياضة', NULL, NULL),
(6, 'أداب', NULL, NULL),
(7, 'أحكام التجويد', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `super_admin`
--

CREATE TABLE `super_admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `assigned_at` date NOT NULL,
  `permissions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `date_of_birth` date NOT NULL,
  `specialization` varchar(128) DEFAULT NULL,
  `qualification` varchar(128) DEFAULT NULL,
  `employment_date` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `academic_level` varchar(128) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `date_of_birth`, `specialization`, `qualification`, `employment_date`, `address`, `academic_level`, `notes`) VALUES
(2, 5, '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(128) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_type` enum('student','teacher','admin','super_admin') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `gender`, `phone`, `user_type`, `created_at`, `updated_at`) VALUES
(3, 'brahmia.lokmeneabdelmoname@univ-guelma.dz', 'لقمان', 'براهمية', '$2y$10$yoSY5fQoZ8zEuPWY1RR1duVf01rJQD3ouxXKzbsAuhYDqwo8tjTbO', 'male', NULL, 'student', '2025-04-11 09:30:59', '2025-04-11 09:30:59'),
(5, 'brahmialokman16@gmail.com', 'محمد', 'سلامة', '$2y$10$nSea/rBZaP.HWa/tsdfwJ.7p/6rNOrYXXk6DUUVr.BqG1qSeHZBhy', 'male', NULL, 'teacher', '2025-04-18 10:25:45', '2025-04-18 10:26:34'),
(6, 'o.chenatlia@gmail.com', 'عبد المومن', 'عبدلي', '$2y$10$AHQUJmWCBvHS2k1x.v1YeuW8QXEfT5Gkyfpc4xEL27ZromHmp7PtS', 'male', NULL, 'student', '2025-04-18 21:07:41', '2025-04-18 21:07:41'),
(7, 'brahmialokman16@proton.me', 'يحي', 'بولحية', '$2y$10$zVaZ3cRUJlPhTUbT7g457uKhTlod0rlfcgHH3Wy0oStECEgxpV9Ie', 'male', NULL, 'student', '2025-04-19 19:15:37', '2025-04-19 19:15:37'),
(10, 'salahaouizzi@gmail.com', 'صلاح الدين', 'عويسي', '$2y$10$XU97V1hnqafswRw2ynlulebXvgsLxB/bzRJq23IfilcGpMEkC3vdG', 'male', NULL, 'student', '2025-05-04 09:11:38', '2025-05-04 09:11:38'),
(11, 'lkljkjk@gmail.com', 'سيد أحمد', 'بوعلي', '$2y$10$RmCvHGdV5O.wNuJg/tLWsO7kmomOCkfBjrcrOW7tHfP2h/lFEtLAC', 'male', NULL, 'student', '2025-05-09 17:52:16', '2025-05-09 17:52:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_progress`
--
ALTER TABLE `academic_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `progress_group` (`group_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `attendance_ibfk_1` (`student_id`),
  ADD KEY `attendance_ibfk_3` (`created_by`);

--
-- Indexes for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curriculum_teacher` (`teacher_id`),
  ADD KEY `curriculum_subject` (`subject_id`),
  ADD KEY `curriculum_group` (`group_id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_subject` (`student_id`),
  ADD KEY `grade_subject` (`subject_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_type_id` (`group_type_id`);

--
-- Indexes for table `group_subjects`
--
ALTER TABLE `group_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `curriculum_id` (`curriculum_id`);

--
-- Indexes for table `group_teachers`
--
ALTER TABLE `group_teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `group_types`
--
ALTER TABLE `group_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_name` (`type_name`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_group` (`group_id`),
  ADD KEY `message_user` (`sender_id`);

--
-- Indexes for table `periods`
--
ALTER TABLE `periods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `period_id` (`period_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_progress`
--
ALTER TABLE `academic_progress`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `curriculum`
--
ALTER TABLE `curriculum`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `group_subjects`
--
ALTER TABLE `group_subjects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_teachers`
--
ALTER TABLE `group_teachers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `group_types`
--
ALTER TABLE `group_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `periods`
--
ALTER TABLE `periods`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_groups`
--
ALTER TABLE `student_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `super_admin`
--
ALTER TABLE `super_admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_progress`
--
ALTER TABLE `academic_progress`
  ADD CONSTRAINT `academic_progress_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `progress_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `curriculum`
--
ALTER TABLE `curriculum`
  ADD CONSTRAINT `curriculum_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `curriculum_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `curriculum_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grade_subject` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `student_subject` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`group_type_id`) REFERENCES `group_types` (`id`);

--
-- Constraints for table `group_subjects`
--
ALTER TABLE `group_subjects`
  ADD CONSTRAINT `group_subjects_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_subjects_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `group_subjects_ibfk_3` FOREIGN KEY (`curriculum_id`) REFERENCES `curriculum` (`id`);

--
-- Constraints for table `group_teachers`
--
ALTER TABLE `group_teachers`
  ADD CONSTRAINT `group_teachers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `group_teachers_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `message_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `message_user` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`period_id`) REFERENCES `periods` (`id`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `schedule_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `student_groups`
--
ALTER TABLE `student_groups`
  ADD CONSTRAINT `student_groups_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `student_groups_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `super_admin`
--
ALTER TABLE `super_admin`
  ADD CONSTRAINT `super_admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
