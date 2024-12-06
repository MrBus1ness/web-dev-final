<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = 'mysql';
$dbname = 'card_shop'; // Replace with your database name

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

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_card'])) {
    $cardIdToDelete = intval($_POST['card_id']);
    $deckId = intval($_POST['deck_id']);
    $columnToDelete = null;

    $deckQuery = "SELECT * FROM decks WHERE deck_id = ?";
    $stmt = $conn->prepare($deckQuery);
    $stmt->bind_param("i", $deckId);
    $stmt->execute();
    $deckResult = $stmt->get_result();
    $deck = $deckResult->fetch_assoc();

    for ($i = 1; $i <= 10; $i++) {
        if ($deck["card$i"] == $cardIdToDelete) {
            $columnToDelete = "card$i";
            break;
        }
    }

    if ($columnToDelete) {
        $deleteQuery = "UPDATE decks SET $columnToDelete = NULL WHERE deck_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $deckId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect to the same page to refresh
            header("Location: deck.php?id=$deckId");
            exit();
        }
    }
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
        <!-- display a success message upon completing an action -->
    <?php if (isset($successMessage)): ?>
        <p class="success-message"><?= htmlspecialchars($successMessage) ?></p>
    <?php endif; ?>

    <?php if (isset($errorMessage)): ?>
        <p class="error-message"><?= htmlspecialchars($errorMessage) ?></p>
    <?php endif; ?>

        <?php if (isset($error)): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php else: ?>
            <h1><?= htmlspecialchars($deck['deck_name']) ?></h1>
            <div class="deck-cards">
                <?php foreach ($cards as $card): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="<?= htmlspecialchars($card['name']) ?>">
                        <h2><?= htmlspecialchars($card['name']) ?></h2>
                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this card?');">
                            <input type="hidden" name="card_id" value="<?= htmlspecialchars($card['card_id']) ?>">
                            <input type="hidden" name="deck_id" value="<?= htmlspecialchars($deck['deck_id']) ?>">
                            <button type="submit" name="delete_card" class="delete-button">Delete</button>
                        </form>
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
