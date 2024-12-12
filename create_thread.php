<?php
session_start(); // Start the session to track the logged-in user

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
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $email = $_POST['email'] ?? null; // Email is optional

    // Insert the new thread into the database
    $stmt = $conn->prepare("
        INSERT INTO forum_threads (title, content, email, created_at)
        VALUES (:title, :content, :email, NOW())
    ");
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        'email' => $email,
    ]);

    // Redirect back to the about page or a confirmation page
    header('Location: about.html');
    exit;

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
