<?php
// Database connection settings
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
    // Establishing the database connection
    $conn = new PDO($dsn, $user, $pass, $options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection failure
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Fetch card details based on the ID passed in the URL
if (isset($_GET['id'])) {
    $card_id = $_GET['id']; // Get the card ID from the URL

    // Prepare the SQL query to fetch the card data
    $query = "SELECT * FROM cards WHERE card_id = ?";
    $stmt = $conn->prepare($query);

    // Bind the card_id parameter to the query
    $stmt->bindParam(1, $card_id, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the card exists and display it
    if ($card) {
        echo "<h1>" . htmlspecialchars($card['name']) . "</h1>";
        echo "<img src='" . htmlspecialchars($card['image_path']) . "' alt='" . htmlspecialchars($card['name']) . "' />";
    } else {
        echo "Card not found.";
    }
} else {
    echo "No card ID specified.";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Details</title>
    <link rel="stylesheet" href="style.css">
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
        <?php if ($card): ?>
            <div class="card-details">
                <h1><?= htmlspecialchars($card['name']) ?></h1>
                <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="<?= htmlspecialchars($card['name']) ?>" class="card-image">
            </div>
        <?php else: ?>
            <p>Card not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
