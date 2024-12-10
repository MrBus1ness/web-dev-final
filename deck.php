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

    for ($i = 10; $i >= 1; $i--) {
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

// Add a card
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_card'])) {
    $newCardId = intval($_POST['card_id']);
    $deckId = intval($_POST['deck_id']);

    // Fetch the deck to find the first empty card slot
    $deckQuery = "SELECT * FROM decks WHERE deck_id = ?";
    $stmt = $conn->prepare($deckQuery);
    $stmt->bind_param("i", $deckId);
    $stmt->execute();
    $deckResult = $stmt->get_result();
    $deck = $deckResult->fetch_assoc();

    // Find the first empty card slot
    $emptySlot = null;
    for ($i = 10; $i >= 1; $i--) {
        if (empty($deck["card$i"])) {
            $emptySlot = "card$i";
            break;
        }
    }

    if ($emptySlot) {
        // Add the new card to the empty slot
        $addCardQuery = "UPDATE decks SET $emptySlot = ? WHERE deck_id = ?";
        $stmt = $conn->prepare($addCardQuery);
        $stmt->bind_param("ii", $newCardId, $deckId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $successMessage = "Card added successfully.";
            // Redirect to refresh the page and show the updated deck
            header("Location: deck.php?id=$deckId");
            exit();
        } else {
            $errorMessage = "Failed to add the card.";
        }
    } else {
        $errorMessage = "Deck is already full (10 cards).";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rename_deck'])) {
    $newDeckName = trim($_POST['new_deck_name']);

    // Validate new deck name
    if (!empty($newDeckName)) {
        try {
            // Update the deck name in the database
            $stmt = $conn->prepare("UPDATE decks SET deck_name = ? WHERE deck_id = ?");
            $stmt->bind_param("si", $newDeckName, $deck_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Refresh the page to reflect changes
                header("Location: deck.php?id=$deck_id");
                exit();
            } else {
                echo "<p style='color: red;'>No changes were made to the deck name.</p>";
            }
        } catch (mysqli_sql_exception $e) {
            echo "<p style='color: red;'>Error renaming deck: " . $e->getMessage() . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Deck name cannot be empty.</p>";
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
    <link rel="stylesheet" href="deckstyles.css">
</head>
<body>
    <header>
        <nav>
            <a href="index.php">Draftsman</a> | 
            <a href="about.html">About</a> | 
            <a href="decks.php">Decks</a>
        </nav>

        <?php if (isset($_SESSION['user_id']) && isset($_SESSION['username'])): ?>
            <!-- User is logged in -->
            <div class="user-dropdown">
                <button class="user-name"><?= htmlspecialchars($_SESSION['username']); ?></button>
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
    <div class="deck-header">
        <h1 id="deck-name"><?= htmlspecialchars($deck['deck_name']) ?></h1>
        <button id="rename-button" onclick="toggleRenameForm()">Rename</button>
    </div>

    <!-- Rename Form -->
    <form id="rename-form" method="POST" action="deck.php?id=<?= htmlspecialchars($deck_id) ?>" style="display: none;">
        <input type="text" name="new_deck_name" placeholder="Enter new deck name" required>
        <button type="submit" name="rename_deck">Submit</button>
    </form>

    <script>
    function toggleRenameForm() {
        const form = document.getElementById('rename-form');
        const button = document.getElementById('rename-button');
        if (form.style.display === 'none') {
            form.style.display = 'block';
            button.style.display = 'none';
        } else {
            form.style.display = 'none';
            button.style.display = 'inline';
        }
    }
    </script>

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
            <hr>
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
            <div class="add-card-container">
                <h2>Add a New Card</h2>
                <form method="POST">
                    <input type="hidden" name="deck_id" value="<?= htmlspecialchars($deck['deck_id']) ?>">
                    
                    <label for="card_name">Search Card:</label>
                    <input type="text" id="card_name" name="card_name" placeholder="Type card name" autocomplete="off">
                    <input type="hidden" id="card_id" name="card_id">

                    <ul id="card-suggestions" class="suggestions-list"></ul>

                    <button type="submit" name="add_card" class="add-button">Add Card</button>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Draftsman</p>
    </footer>

    <!-- Search Suggestions JavaScript -->
    <script>
        const cardInput = document.getElementById('card_name');
        const suggestionsList = document.getElementById('card-suggestions');
        const cardIdField = document.getElementById('card_id');

        cardInput.addEventListener('input', async () => {
            const query = cardInput.value;

            // Clear previous suggestions if input is empty
            if (!query) {
                suggestionsList.innerHTML = '';
                cardIdField.value = '';
                return;
            }

            // Fetch suggestions from the backend
            const response = await fetch(`search_cards.php?term=${encodeURIComponent(query)}`);
            if (!response.ok) {
                console.error('Failed to fetch card suggestions');
                return;
            }

            const cards = await response.json();

            // Display suggestions
            suggestionsList.innerHTML = '';
            cards.forEach(card => {
                const suggestionItem = document.createElement('li');
                suggestionItem.textContent = card.name;
                suggestionItem.dataset.cardId = card.card_id;

                // Add click listener to select a card
                suggestionItem.addEventListener('click', () => {
                    cardInput.value = card.name;
                    cardIdField.value = card.card_id;
                    suggestionsList.innerHTML = ''; // Clear suggestions
                });

                suggestionsList.appendChild(suggestionItem);
            });
        });

        // Hide suggestions when clicking outside the input
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.add-card-container')) {
                suggestionsList.innerHTML = '';
            }
        });
    </script>

</body>
</html>
