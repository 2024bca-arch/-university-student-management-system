<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/database.php";

$sql = "SELECT * FROM students ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records | University Portal</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="records-container">

    <h1>University Student Records</h1>

    <p class="welcome-text">
        Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!
    </p>

    <div class="records-actions">
        <a href="add.php" class="add-btn">+ Add New Student</a>
    </div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Register Number</th>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Semester</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php if ($result && $result->num_rows > 0) { ?>

                <?php while ($row = $result->fetch_assoc()) { ?>

                    <tr>
                        <td><?php echo $row["id"]; ?></td>

                        <td><?php echo htmlspecialchars($row["register_number"]); ?></td>

                        <td><?php echo htmlspecialchars($row["student_name"]); ?></td>

                        <td><?php echo htmlspecialchars($row["course"]); ?></td>

                        <td><?php echo $row["semester"]; ?></td>

                        <td><?php echo htmlspecialchars($row["email"]); ?></td>

                        <td><?php echo htmlspecialchars($row["contact_number"]); ?></td>

                        <td class="action-buttons">

                            <a class="edit-btn"
                               href="edit.php?id=<?php echo (int)$row["id"]; ?>">
                               Edit
                            </a>

                            <form method="POST"
                                  action="delete.php"
                                  onsubmit="return confirm('Are you sure you want to delete this student?');">

                                <input type="hidden"
                                       name="id"
                                       value="<?php echo (int)$row["id"]; ?>">

                                <button type="submit" class="delete-btn">
                                    Delete
                                </button>

                            </form>

                        </td>
                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="8">No student records found.</td>
                </tr>

            <?php } ?>

            </tbody>
        </table>

    </div>

    <div class="records-footer">
        <a href="../dashboard.php">← Back to Dashboard</a>
    </div>

</div>

</body>
</html>
