<?php
session_start();

// Check User Login
if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit();
}

// Database Connection
require_once "config/database.php";

// Get Total Students
$sql = "SELECT COUNT(*) AS total FROM students";
$result = $conn->query($sql);

$total_students = 0;

if ($result) {
    $row = $result->fetch_assoc();
    $total_students = (int)$row["total"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>University Admin Dashboard</title>

    <!-- CSS File -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="dashboard-container">

    <!-- HEADER SECTION -->
    <header class="dashboard-header">

        <div class="brand-info">
            <h1>University Portal</h1>
            <p>Student Information Management System</p>
        </div>

        <div class="user-info">

            <span>
                Welcome,
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </span>

            <a href="auth/logout.php" class="logout-btn">
                Logout
            </a>

        </div>

    </header>


    <!-- DASHBOARD TITLE -->
    <h2>Admin Dashboard</h2>


    <!-- TOTAL STUDENTS CARD -->
    <div class="total-card">

        <h3>Total Students</h3>

        <p class="student-count">
            <?php echo $total_students; ?>
        </p>

        <span>Registered Students</span>

    </div>


    <!-- DASHBOARD MENU CARDS -->
    <div class="dashboard-grid">


        <!-- ADD STUDENT -->
        <a href="students/add.php" class="dashboard-card">

            <div class="card-icon">+</div>

            <h3>Add Student</h3>

            <p>Add a new student record to the database.</p>

        </a>


        <!-- VIEW STUDENTS -->
        <a href="students/index.php" class="dashboard-card">

            <div class="card-icon">👨‍🎓</div>

            <h3>View Students</h3>

            <p>Display, edit and delete student records.</p>

        </a>


        <!-- EXPORT XML -->
        <a href="xml/export.php" class="dashboard-card">

            <div class="card-icon">📁</div>

            <h3>Export XML</h3>

            <p>Export student information into XML format.</p>

        </a>


        <!-- VIEW XML -->
        <a href="xml/display.php" class="dashboard-card">

            <div class="card-icon">📄</div>

            <h3>View XML Records</h3>

            <p>View student information stored in XML.</p>

        </a>


    </div>


    <!-- FOOTER -->
    <footer class="dashboard-footer">

        <p>
            University Student Information and Academic Management System
        </p>

        <p>
            © 2026 University Portal | All Rights Reserved
        </p>

    </footer>

</div>

</body>
</html>
