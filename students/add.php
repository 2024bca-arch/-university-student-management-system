<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $register_number = trim($_POST["register_number"]);
    $student_name = trim($_POST["student_name"]);
    $course = trim($_POST["course"]);
    $semester = (int)$_POST["semester"];
    $email = trim($_POST["email"]);
    $contact_number = trim($_POST["contact_number"]);

    if (
        empty($register_number) ||
        empty($student_name) ||
        empty($course) ||
        empty($email) ||
        empty($contact_number) ||
        $semester < 1 ||
        $semester > 8 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        !preg_match("/^[0-9]{10,15}$/", $contact_number)
    ) {
        $message = "Please enter valid details in all fields.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO students
            (register_number, student_name, course, semester, email, contact_number)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "sssiss",
            $register_number,
            $student_name,
            $course,
            $semester,
            $email,
            $contact_number
        );

        if ($stmt->execute()) {
            $message = "Student added successfully!";
        } else {
            $message = "Error: Register number may already exist.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Student</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <div class="page-container">

        <h1>Add New Student</h1>

        <?php if (!empty($message)) { ?>
            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form method="POST" onsubmit="return validateStudentForm();">

            <input
                type="text"
                id="register_number"
                name="register_number"
                placeholder="Register Number"
                required
            >
            <br><br>

            <input
                type="text"
                id="student_name"
                name="student_name"
                placeholder="Student Name"
                required
            >
            <br><br>

            <input
                type="text"
                id="course"
                name="course"
                placeholder="Course (e.g. BCA)"
                required
            >
            <br><br>

            <input
                type="number"
                id="semester"
                name="semester"
                placeholder="Semester"
                min="1"
                max="8"
                required
            >
            <br><br>

            <input
                type="email"
                id="email"
                name="email"
                placeholder="Email Address"
                required
            >
            <br><br>

            <input
                type="text"
                id="contact_number"
                name="contact_number"
                placeholder="Contact Number"
                maxlength="15"
                required
            >
            <br><br>

            <button type="submit">Add Student</button>

        </form>

        <div class="page-links">

            <a href="index.php">View Student Records</a>

            <a href="../dashboard.php">Back to Dashboard</a>

        </div>

    </div>

    <script src="../js/validation.js"></script>

</body>
</html>
