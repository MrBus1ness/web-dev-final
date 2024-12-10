<?php
session_start();

// Database connection
$host = 'localhost'; 
$dbname = 'card_shop'; 
$user = 'root'; 
$pass = 'mysql';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to authenticate user
    $stmt = $conn->prepare("SELECT user_id, username, password FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['user_id']; // Store the user_id in session
        $_SESSION['username'] = $user['username']; // Optional: Store username if needed

        // Redirect to the main page
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid username or password.";
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
            <a href="index.php">Draftsman</a> | 
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
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <!-- Buttons -->
                <div class="buttons">
                    <button type="button" class="register-button" onclick="window.location.href='register.php'">Register</button>
                    <button type="submit" class="login" name="login">Login</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>