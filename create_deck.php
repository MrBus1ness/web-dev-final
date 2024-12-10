<?php
session_start();
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
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$userId = $_SESSION['user_id'];

try {
    // Insert a new empty deck for the user
    $stmt = $conn->prepare("INSERT INTO decks (deck_name, owner_id) VALUES (:deck_name, :owner_id)");
    $stmt->bindValue(':deck_name', 'New Deck'); // Default name; you can make this dynamic
    $stmt->bindValue(':owner_id', $userId);
    $stmt->execute();

    // Get the ID of the newly created deck
    $newDeckId = $conn->lastInsertId();

    // Redirect to the new deck's page
    header("Location: deck.php?id=$newDeckId");
    exit();
} catch (PDOException $e) {
    echo "Error creating deck: " . $e->getMessage();
}
?>
