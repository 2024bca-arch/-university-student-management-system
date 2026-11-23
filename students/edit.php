<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/database.php";

$message = "";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid student ID.");
}

// Update student details
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $register_number = trim($_POST["register_number"]);
    $student_name = trim($_POST["student_name"]);
    $course = trim($_POST["course"]);
    $semester = (int)$_POST["semester"];
    $email = trim($_POST["email"]);
    $contact_number = trim($_POST["contact_number"]);

    if (
        !$id || $register_number === "" ||
        $student_name === "" || $course === "" ||
        $semester < 1 || $semester > 12 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        $contact_number === ""
    ) {
        $message = "Please enter valid details.";
    } else {

        $stmt = $conn->prepare(
            "UPDATE students SET
            register_number = ?,
            student_name = ?,
            course = ?,
            semester = ?,
            email = ?,
            contact_number = ?
            WHERE id = ?"
        );

        $stmt->bind_param(
            "sssissi",
            $register_number,
            $student_name,
            $course,
            $semester,
            $email,
            $contact_number,
            $id
        );

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $message = "Update failed. Register number may already exist.";
        }

        $stmt->close();
    }
}

// Fetch existing student details
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    die("Student not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h1>Edit Student Details</h1>

<p style="color:red;">
    <?php echo htmlspecialchars($message); ?>
</p>

<form method="POST">

    <input type="hidden" name="id"
    value="<?php echo $student['id']; ?>">

    <input type="text" name="register_number"
    value="<?php echo htmlspecialchars($student['register_number']); ?>"
    required>
    <br><br>

    <input type="text" name="student_name"
    value="<?php echo htmlspecialchars($student['student_name']); ?>"
    required>
    <br><br>

    <input type="text" name="course"
    value="<?php echo htmlspecialchars($student['course']); ?>"
    required>
    <br><br>

    <input type="number" name="semester"
    min="1" max="12"
    value="<?php echo $student['semester']; ?>"
    required>
    <br><br>

    <input type="email" name="email"
    value="<?php echo htmlspecialchars($student['email']); ?>"
    required>
    <br><br>

    <input type="text" name="contact_number"
    value="<?php echo htmlspecialchars($student['contact_number']); ?>"
    maxlength="15"
    required>
    <br><br>

    <button type="submit">Update Student</button>

</form>

<br>
<a href="index.php">Back to Student List</a>

</body>
</html>
