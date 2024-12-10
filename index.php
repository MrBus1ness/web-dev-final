<?php
session_start(); // Start the session to track the logged-in user

$host = 'localhost'; 
$dbname = 'card_shop'; 
$user = 'hunter'; 
$pass = 'hunter';
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

    $loggedInUserId = $_SESSION['user_id'];

    // Fetch decks owned by the logged-in user
    $userDecks = [];
    if ($loggedInUserId) {
        $stmt = $conn->prepare("
            SELECT 
                d.deck_id, 
                d.deck_name, 
                c.name AS card1_name, 
                c.image_path AS card1_image
            FROM decks d
            JOIN cards c ON d.card1 = c.card_id
            WHERE d.owner_id = :user_id
        ");
        $stmt->execute(['user_id' => $loggedInUserId]);
        $userDecks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all other decks
    $stmt = $conn->prepare("
        SELECT 
            d.deck_id, 
            d.deck_name, 
            c.name AS card1_name, 
            c.image_path AS card1_image
        FROM decks d
        JOIN cards c ON d.card1 = c.card_id
        WHERE d.owner_id != :user_id OR d.owner_id IS NULL
        LIMIT 6
    ");
    $stmt->execute(['user_id' => $loggedInUserId]);
    $otherDecks = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTG Deck Builder - Draftsman</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Draftsman</a> | 
            <a href="about.html">About</a> | 
            <a href="decks.php">Decks</a>
        </nav>

        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])): ?>
            <!-- User is logged in -->
            <div class="user-dropdown">
                <button class="user-name"><?= htmlspecialchars($_SESSION['user_name']); ?></button>
                <div class="dropdown-menu">
                    <form method="POST" action="logout.php">
                        <button type="submit" class="logout-button">Log Out</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <!-- User is not logged in -->
            <button class="login-button" onclick="window.location.href='login.php'">Login</button>
        <?php endif; ?>
    </header>

    <main>

        <!-- Hero Section -->
        <div class="hero">
            <h1>Welcome to Draftsman</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search for decks or cards...">
                <button>Search</button>
            </div>
            <button class="hero-button" onclick="window.location.href='create_deck.php'">New Deck</button>
        </div>

        <!-- User Decks -->
        <?php if (!empty($userDecks)) { ?>
            <h1 style="text-align: center; margin-top: 20px;">Your Decks</h1>
            <div class="deck-preview-container">
                <?php foreach ($userDecks as $deck) { ?>
                    <div class="deck-preview" onclick="window.location.href='deck.php?id=<?= htmlspecialchars($deck['deck_id']) ?>'">
                        <img src="<?= htmlspecialchars($deck['card1_image']) ?>" alt="Preview of <?= htmlspecialchars($deck['deck_name']) ?>" class="deck-image">
                        <div class="gradient-overlay"></div>
                        <div class="deck-info"><?= htmlspecialchars($deck['deck_name']) ?></div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>

        <!-- Other Decks -->
        <h1 style="text-align: center; margin-top: 20px;">Other Decks</h1>
        <div class="deck-preview-container">
            <?php if (!empty($otherDecks)) { ?>
                <?php foreach ($otherDecks as $deck) { ?>
                    <div class="deck-preview" onclick="window.location.href='deck.php?id=<?= htmlspecialchars($deck['deck_id']) ?>'">
                        <img src="<?= htmlspecialchars($deck['card1_image']) ?>" alt="Preview of <?= htmlspecialchars($deck['deck_name']) ?>" class="deck-image">
                        <div class="gradient-overlay"></div>
                        <div class="deck-info"><?= htmlspecialchars($deck['deck_name']) ?></div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No decks found.</p>
            <?php } ?>
        </div>
    </main>
</body>
</html>
