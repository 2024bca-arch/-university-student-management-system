<?php
session_start();

require_once "../config/database.php";

$message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: ../dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($confirm_password)
    ) {
        $message = "Please fill all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";

    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";

    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {

            $message = "Email already registered.";

        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (username, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $username,
                $email,
                $hashed_password
            );

            if ($stmt->execute()) {
                $message = "Registration successful! You can now login.";
            } else {
                $message = "Registration failed. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Signup | University Portal</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-brand">
        <h1>University Portal</h1>
        <p>Student Information Management System</p>
    </div>

    <div class="auth-card">

        <h2>Create Account</h2>

        <p class="auth-subtitle">
            Register to access the university portal.
        </p>

        <?php if (!empty($message)) { ?>
            <p class="auth-message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form method="POST">

            <label>Full Name</label>

            <input
                type="text"
                name="username"
                placeholder="Enter your name"
                required
            >

            <label>Email Address</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Minimum 8 characters"
                minlength="8"
                required
            >

            <label>Confirm Password</label>

            <input
                type="password"
                name="confirm_password"
                placeholder="Confirm your password"
                minlength="8"
                required
            >

            <button type="submit" class="auth-button">
                Create Account
            </button>

        </form>

        <p class="auth-link">
            Already have an account?
            <a href="login.php">Login Here</a>
        </p>

    </div>

    <footer class="auth-footer">
        © 2026 University Portal. All Rights Reserved.
    </footer>

</div>

</body>
</html>
