<?php
// Get the card ID from the query parameter
if (isset($_GET['id'])) {
    $cardId = $_GET['id'];

    // Fetch the card details from the database
    $host = 'localhost'; // Your database connection details
    $username = 'root';
    $password = 'mysql';
    $dbname = 'card_shop';
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT card_id, name, image_path, description FROM cards WHERE card_id = ?");
    $stmt->bind_param("i", $cardId);
    $stmt->execute();
    $result = $stmt->get_result();
    $card = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
} else {
    // If no card ID is provided, redirect back to the homepage or show an error
    header("Location: index.php");
    exit;
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
            <a href="index.php">Home</a> | 
            <a href="about.html">About</a> | 
            <a href="decks.php">Decks</a>
        </nav>
    </header>

    <main>
        <?php if ($card): ?>
            <div class="card-details">
                <h1><?= htmlspecialchars($card['name']) ?></h1>
                <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="<?= htmlspecialchars($card['name']) ?>" class="card-image">
                <p><?= htmlspecialchars($card['description']) ?></p>
            </div>
        <?php else: ?>
            <p>Card not found.</p>
        <?php endif; ?>
    </main>
</body>
</html>
