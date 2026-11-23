<?php
session_start();

require_once "../config/database.php";

$message = "";

if (isset($_SESSION["user_id"])) {
    header("Location: ../dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare(
        "SELECT id, username, password FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: ../dashboard.php");
            exit();

        } else {
            $message = "Incorrect email or password.";
        }

    } else {
        $message = "Incorrect email or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | University Portal</title>

    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

<div class="auth-container">

    <div class="auth-brand">
        <h1>University Portal</h1>
        <p>Student Information Management System</p>
    </div>

    <div class="auth-card">

        <h2>Welcome Back!</h2>

        <p class="auth-subtitle">
            Login to access your university dashboard.
        </p>

        <?php if (!empty($message)) { ?>
            <p class="auth-error">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php } ?>

        <form method="POST">

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
                placeholder="Enter your password"
                required
            >

            <button type="submit" class="auth-button">
                Login
            </button>

        </form>

        <p class="auth-link">
            Don't have an account?
            <a href="register.php">Create Account</a>
        </p>

    </div>

    <footer class="auth-footer">
        © 2026 University Portal. All Rights Reserved.
    </footer>

</div>

</body>
</html>
