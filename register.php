<?php
// register.php - Registration page
session_start();
require_once 'config.php';
require_once 'auth.php';

$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($password !== $confirm_password) {
            $error_message = 'Passwords do not match';
        } else if (strlen($password) < 6) {
            $error_message = 'Password must be at least 6 characters';
        } else {
            if (register_user($pdo, $username, $password)) {
                $success_message = 'Registration successful! You can now login.';
            } else {
                $error_message = 'Username already exists';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Draftsman</title>
    <link rel="stylesheet" href="registerstyles.css">
    <link rel="icon" href="draftsman_favicon.ico" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Draftsman</a> | 
            <a href="about.php">About</a> | 
            <a href="user_decks.php">Decks</a>
        </nav>

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-dropdown">
                <button class="user-name"><?= htmlspecialchars($_SESSION['username']); ?></button>
                <div class="dropdown-menu">
                    <form method="POST" action="logout.php">
                        <button type="submit" class="logout-button">Log Out</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <button class="login-button" onclick="window.location.href='login.php'">Login</button>
        <?php endif; ?>

    </header>

    <main>
        <div class="register-container">
        <!-- Logo Section -->
            <div class="logo">
                <img src="draftsman_logo.png" alt="Logo"> <!-- Replace with your logo URL -->
                <h1>Register</h1>
                <?php if ($error_message): ?>
                    <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
                <?php if ($success_message): ?>
                    <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
                <?php endif; ?>
            </div>

            <!-- Registration Fields -->
            <form method="POST" action="" class="auth-form">
                <div class="form-group">
                    <input type="text" placeholder="Username" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required>
                </div>

                <!-- Buttons -->
                <div class="buttons">
                    <button type="submit" class="register-button" name="register">Register</button>
                    <button type="button" class="login" onclick="window.location.href='login.php'">Login</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>