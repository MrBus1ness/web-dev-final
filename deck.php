<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'your_database_name'; // Replace with your database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get deck_id from the URL
$deck_id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Fetch deck and associated cards
if ($deck_id) {
    // Fetch the deck data
    $deckQuery = "SELECT * FROM decks WHERE deck_id = ?";
    $stmt = $conn->prepare($deckQuery);
    $stmt->bind_param("i", $deck_id);
    $stmt->execute();
    $deckResult = $stmt->get_result();

    if ($deckResult->num_rows > 0) {
        $deck = $deckResult->fetch_assoc();

        // Fetch card details for the deck
        $cards = [];
        for ($i = 1; $i <= 10; $i++) { // Assuming card1, card2, ..., card10
            $cardId = $deck["card$i"];
            if ($cardId) {
                $cardQuery = "SELECT * FROM cards WHERE card_id = ?";
                $cardStmt = $conn->prepare($cardQuery);
                $cardStmt->bind_param("i", $cardId);
                $cardStmt->execute();
                $cardResult = $cardStmt->get_result();
                if ($cardResult->num_rows > 0) {
                    $cards[] = $cardResult->fetch_assoc();
                }
                $cardStmt->close();
            }
        }
    } else {
        $error = "Deck not found.";
    }
    $stmt->close();
} else {
    $error = "No deck ID specified.";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deck Details</title>
    <link rel="stylesheet" href="deckstyles.css"> <!-- Link to your CSS -->
</head>
<body>
    <header>
        <nav>
            <a href="index.html">Home</a> | 
            <a href="about.html">About</a> | 
            <a href="decks.php">All Decks</a>
        </nav>
    </header>

    <main>
        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php else: ?>
            <h1><?= htmlspecialchars($deck['deck_name']) ?></h1>
            <div class="deck-cards">
                <?php foreach ($cards as $card): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="<?= htmlspecialchars($card['name']) ?>">
                        <h2><?= htmlspecialchars($card['name']) ?></h2>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Draftsman</p>
    </footer>
</body>
</html>
