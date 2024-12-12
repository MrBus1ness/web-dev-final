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
$card = null; // Initialize card variable
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTG Deck Builder - Draftsman</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="draftsman_favicon.ico" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        header {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin: 40px auto;
            max-width: 800px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .card-image {
            flex: 1;
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
            border-right: 1px solid #ddd;
        }

        .card-image img {
            max-width: 100%;
            height: auto;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .card-info {
            flex: 2;
            padding: 20px;
        }

        .card-info h2 {
            margin-top: 0;
            font-size: 1.8rem;
            color: #222;
        }

        .card-info p {
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        .card-info .attribute {
            margin-bottom: 10px;
            font-weight: bold;
            color: #444;
        }

        .card-info .attribute span {
            font-weight: normal;
            color: #666;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            color: #777;
        }

        footer a {
            color: #FF5733;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
        <nav>
            <a href="index.php">Draftsman</a> | 
            <a href="about.php">About</a> | 
            <a href="user_decks.php">Decks</a>
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
        <div class="card-image">
            <img src="<?= htmlspecialchars($card['image_path']); ?>" alt="<?= htmlspecialchars($card['name']); ?>">
        </div>
        <div class="card-info">
            <h2><?= htmlspecialchars($card['name']); ?></h2>
            <p class="attribute">Supertype: <span><?= htmlspecialchars($card['supertype']); ?></span></p>
            <p class="attribute">Type: <span><?= htmlspecialchars($card['type']); ?></span></p>
            <p class="attribute">Subtype: <span><?= htmlspecialchars($card['subtype']); ?></span></p>
            <p class="attribute">Mana Cost: <span><?= htmlspecialchars($card['mana']); ?></span></p>
        </div>
    <?php else: ?>
        <p>Card not found.</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; <?= date('Y'); ?> Draftsman. <a href="index.php">Home</a></p>
</footer>

</body>
</html>
