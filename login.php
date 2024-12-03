<?php
// login.php - Login page
session_start();
require_once 'config.php';
require_once 'auth.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        if (login_user($pdo, $username, $password)) {
            header('Location: index.php');
            exit;
        } else {
            $error_message = 'Invalid username or password';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Draftsman</title>
    <link rel="stylesheet" href="loginstyles.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.html">Draftsman</a> | 
            <a href="about.html">About</a> | 
            <a href="decks.php">Decks</a>
        </nav>

        <button class="login-button" onclick="window.location.href='login.php'">Login</button>
    </header>
    <main>
        <div class="login-container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="logo.png" alt="Logo"> <!-- Replace with your logo URL -->
            <h1>Login</h1>
            <?php if ($error_message): ?>
                <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
        </div>

        <!-- Login Fields -->
        <form method="POST" action="" class="auth-form">
            <div class="form-group">
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" required>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button type="button" class="register-button" onclick="window.location.href='register.php'">Register</button>
                <button type="submit" class="login" name="login" >Login</button>
            </div>
        </form>
    </div>
    </main>
</body>
</html>