<?php
session_start();

// التحقق مما إذا كان المستخدم قد سجل الدخول وأنه طالب
if (!isset($_SESSION['login_in']) || $_SESSION['login_in'] !== true || !isset($_SESSION['student_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: /quranic/login.php");
    exit();
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

?>




<script type="text/javascript">
        var gk_isXlsx = false;
        var gk_xlsxFileLookup = {};
        var gk_fileData = {};
        function filledCell(cell) {
          return cell !== '' && cell != null;
        }
        function loadFileData(filename) {
        if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
            try {
                var workbook = XLSX.read(gk_fileData[filename], { type: 'base64' });
                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];

                // Convert sheet to JSON to filter blank rows
                var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
                // Filter out blank rows (rows where all cells are empty, null, or undefined)
                var filteredData = jsonData.filter(row => row.some(filledCell));

                // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
                var headerRowIndex = filteredData.findIndex((row, index) =>
                  row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
                );
                // Fallback
                if (headerRowIndex === -1 || headerRowIndex > 25) {
                  headerRowIndex = 0;
                }

                // Convert filtered JSON back to CSV
                var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
                csv = XLSX.utils.sheet_to_csv(csv, { header: 1 });
                return csv;
            } catch (e) {
                console.error(e);
                return "";
            }
        }
        return gk_fileData[filename] || "";
        }
        </script>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطالب - جمعية العلماء المسلمين</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="welcome-msg">
            أهلا بك يا <span>الطالب <?= $_SESSION['name'] ?? " " ?> </span>
        </div>
        <div class="header-icons">
            <i class="fas fa-bell"></i>
            <i class="fas fa-envelope"></i>
            <i class="fas fa-cog"></i>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="../../img/شعار.png" alt="جمعية العلماء المسلمين">
                <p>جمعية العلماء المسلمين الجزائريين</p>
            </div>
            <ul class="sidebar-menu">
                <li class="active" style="background-color:#B0E4C4;">
                    <a href="index.php">لوحة التحكم</a>
                </li>
                <li>
                    <a href="student-schedule.php">البرنامج</a>
                </li>
                <li>
                    <a href="student-messages.php">الرسائل</a>
                </li>
                <li>
                    <a href="student-progress.php">المتابعة</a>
                </li>
                <li>
                    <a href="student-profile.php">الملف الشخصي</a>
                </li>
            </ul>
            <div class="register-btn">
                <i class="fas fa-arrow-left"></i> <a href="../student/logout.php" style="color: white;">تسجيل الخروج</a>
            </div>
        </div>