<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

$file = __DIR__ . "/students.xml";

if (!file_exists($file)) {
    die("XML file not found. Please export student records first.");
}

$xml = simplexml_load_file($file);

if ($xml === false) {
    die("Unable to read XML file.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XML Student Records</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 30px;
        }
        h1 { color: #1e3a5f; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #1e3a5f;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            margin-right: 12px;
        }
    </style>
</head>
<body>

<h1>XML Student Records</h1>

<?php if (isset($_GET["exported"])) { ?>
    <p>XML file exported successfully!</p>
<?php } ?>

<table>
    <tr>
        <th>ID</th>
        <th>Register Number</th>
        <th>Student Name</th>
        <th>Course</th>
        <th>Semester</th>
        <th>Email</th>
        <th>Contact Number</th>
    </tr>

    <?php foreach ($xml->student as $student) { ?>
    <tr>
        <td><?php echo htmlspecialchars((string)$student->id); ?></td>
        <td><?php echo htmlspecialchars((string)$student->register_number); ?></td>
        <td><?php echo htmlspecialchars((string)$student->student_name); ?></td>
        <td><?php echo htmlspecialchars((string)$student->course); ?></td>
        <td><?php echo htmlspecialchars((string)$student->semester); ?></td>
        <td><?php echo htmlspecialchars((string)$student->email); ?></td>
        <td><?php echo htmlspecialchars((string)$student->contact_number); ?></td>
    </tr>
    <?php } ?>
</table>

<a href="export.php">Refresh XML Data</a>
<a href="../dashboard.php">Back to Dashboard</a>

</body>
</html>
