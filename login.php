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
        <div class="auth-container">
            <h1>Login</h1>
            <?php if ($error_message): ?>
                <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" class="auth-form">
                <div>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
        <div class="login-container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="logo.png" alt="Logo"> <!-- Replace with your logo URL -->
            <h1>Login</h1>
        </div>

        <!-- Login Fields -->
        <form>
            <div class="form-group">
                <input type="text" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" required>
            </div>

            <!-- Buttons -->
            <div class="buttons">
                <button type="submit" class="login-button">Login</button>
                <button type="button" class="register-button" onclick="window.location.href='register.html'">Register</button>
            </div>
        </form>
    </div>
    </main>
</body>
</html>