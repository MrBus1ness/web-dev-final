<!-- 
 CS 351 Final
 Hunter Runyon
-->

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

    // Check if the user is logged in
    $loggedInUserId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $loggedInUserName = isset($_SESSION['username']) ? $_SESSION['username'] : null;

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

    // Fetch all other decks (or all decks if no user is logged in)
    if ($loggedInUserId) {
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
    } else {
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
    }
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

        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-dropdown">
                <button class="user-name"><?= htmlspecialchars($_SESSION['username']); ?></button>
                <div class="dropdown-menu">
                    <form method="POST" action="logout.php">
                        <button type="submit" class="logout-button">Log Out</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <button class="login-button" onclick="window.location.href='login.php'">Login</button>
        <?php endif; ?>

    </header>

    <main>

        <!-- Hero Section -->
        <div class="hero">
            <h1>Welcome to Draftsman</h1>
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search for decks or cards...">
                <button type="button" id="search-button">Search</button>
            </div>
            <div id="search-results" class="search-results"></div>
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
    <!-- search bar script -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const searchResults = document.getElementById('search-results');

        // Function to fetch search results
        const fetchSearchResults = async (term) => {
            try {
                const response = await fetch(`search_cards.php?term=${encodeURIComponent(term)}`);
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error fetching search results:', error);
                return [];
            }
        };

        // Function to display search results
        const displayResults = (results) => {
            if (results.length > 0) {
                const resultsHtml = results.map(card => `<li>${card.name}</li>`).join('');
                searchResults.innerHTML = `<ul>${resultsHtml}</ul>`;
                searchResults.style.display = 'block';
            } else {
                searchResults.innerHTML = '<p>No results found</p>';
                searchResults.style.display = 'block';
            }
        };

        // Event listener for typing in search input
        searchInput.addEventListener('input', async () => {
            const term = searchInput.value.trim();
            if (term.length > 2) { // Fetch results only if term length > 2
                const results = await fetchSearchResults(term);
                displayResults(results);
            } else {
                searchResults.style.display = 'none';
            }
        });

        // Optional: Hide results when clicking outside
        document.addEventListener('click', (event) => {
            if (!searchResults.contains(event.target) && event.target !== searchInput) {
                searchResults.style.display = 'none';
            }
        });
    });
    </script>

    <script>
        // Handle search suggestion click
        function handleSearchResultClick(cardId) {
            window.location.href = `card.php?id=${cardId}`; // Redirect to card details page
        }

        // Update the displaySearchResults function to include the card ID
        function displaySearchResults(results) {
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = ''; // Clear previous results

            results.forEach(result => {
                const listItem = document.createElement('li');
                listItem.textContent = result.name;

                // Attach the click event to redirect to the card details page
                listItem.addEventListener('click', () => handleSearchResultClick(result.card_id));

                resultsContainer.appendChild(listItem);
            });

            // Show the results container
            resultsContainer.style.display = 'block';
        }
    </script>

</body>


</body>
</html>
