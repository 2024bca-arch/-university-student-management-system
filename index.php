<?php
session_start();

// If user is already logged in, open Dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Welcome | University Portal</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="welcome-container">

    <header class="welcome-header">
        <h1>University Portal</h1>
        <p>Student Information and Academic Management System</p>
    </header>

    <main class="welcome-content">

        <div class="welcome-icon">🎓</div>

        <h2>Welcome to Our University Portal</h2>

        <p>
            Manage student information, academic records
            and university data through one simple platform.
        </p>

        <div class="welcome-buttons">

            <a href="auth/login.php" class="welcome-login">
                Login
            </a>

            <a href="auth/register.php" class="welcome-register">
                Create Account
            </a>

        </div>

    </main>

    <footer class="welcome-footer">
        © 2026 University Portal. All Rights Reserved.
    </footer>

</div>

</body>
</html>
