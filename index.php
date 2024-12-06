<!-- 
CS 351
Final Project Index
 -->

 <?php
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

    // Fetch decks and their first card details
    $stmt = $conn->prepare("
        SELECT 
            d.deck_id, 
            d.deck_name, 
            c.name AS card1_name, 
            c.image_path AS card1_image
        FROM decks d
        JOIN cards c ON d.card1 = c.card_id
        LIMIT 6
    ");
    $stmt->execute();
    $decks = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="index.html">Draftsman</a> | 
            <a href="about.html">About</a> | 
            <a href="decks.php">Decks</a>
        </nav>

        <button class="login-button" onclick="window.location.href='login.php'">Login</button>
    </header>
    <main>

        <!-- Hero Section -->
        <div class="hero">
            <h1>Welcome to Draftsman</h1>
            <div class="search-bar">
                <input type="text" placeholder="Search for decks or cards...">
                <button>Search</button>
            </div>
            <button class="hero-button" onclick="window.location.href='get-started.html'">New Deck</button>
        </div>

        <!-- Deck Previews -->
        <h1 style="text-align: center; margin-top: 20px;">Deck Previews</h1>
        <div class="deck-preview-container">
        <?php
        if (!empty($decks)) {
            foreach ($decks as $deck) {
                ?>
                <div class="deck-preview" onclick="window.location.href='deck.php?id=<?= htmlspecialchars($deck['deck_id']) ?>'">
                    <img style="max-width: 150px; max-height: 100%; object-fit: cover; display: block;" src="<?= htmlspecialchars($deck['card1_image']) ?>" alt="Preview of <?= htmlspecialchars($deck['deck_name']) ?>" class="deck-image">
                    <div class="gradient-overlay"></div>
                    <div class="deck-info"><?= htmlspecialchars($deck['deck_name']) ?></div>
                    </div>
                    <?php
                } 
            } else {
                echo "No decks found.";
            }
            ?>
        </div>
    </main>
</body>