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
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
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

// Handle book search
// $search_results = null;
// if (isset($_GET['search']) && !empty($_GET['search'])) {
//     $search_term = '%' . $_GET['search'] . '%';
//     $search_sql = 'SELECT student_id, student_name, class_grade FROM lea WHERE student_id LIKE :search';
//     $search_stmt = $pdo->prepare($search_sql);
//     $search_stmt->execute(['search' => $search_term]);
//     $search_results = $search_stmt->fetchAll();
// }

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if (isset($_POST['student_id']) && isset($_POST['student_name']) && isset($_POST['class_grade'])) {
//         // Insert new entry
//         $student_id = htmlspecialchars($_POST['student_id']);
//         $student_name = htmlspecialchars($_POST['student_name']);
//         $class_grade = htmlspecialchars($_POST['class_grade']);
        
//         $insert_sql = 'INSERT INTO lea (student_id, student_name, class_grade) VALUES (:student_id, :student_name, :class_grade)';
//         $stmt_insert = $pdo->prepare($insert_sql);
//         $stmt_insert->execute(['student_id' => $student_id, 'student_name' => $student_name, 'class_grade' => $class_grade]);
//     } elseif (isset($_POST['delete_id'])) {
//         // Delete an entry
//         $delete_id = (int) $_POST['delete_id'];
        
//         $delete_sql = 'DELETE FROM lea WHERE student_id = :student_id';
//         $stmt_delete = $pdo->prepare($delete_sql);
//         $stmt_delete->execute(['student_id' => $delete_id]);
//     }
// }

// // get everything for main table
// $sql = 'SELECT student_id, student_name, class_grade FROM lea';
// $stmt = $pdo->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTG Deck Builder - Draftsman</title>
    <link rel="stylesheet" href="styles.css">
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
            <?php foreach ($decks as $deck): ?>
                <div class="deck-card">
                    <img src="<?= htmlspecialchars($deck['card1_image']) ?>" alt="<?= htmlspecialchars($deck['card1_name']) ?>" class="deck-thumbnail">
                    <div class="deck-info">
                        <div class="deck-title"><?= htmlspecialchars($deck['deck_name']) ?></div>
                        <a href="deck.php?id=<?= $deck['deck_id'] ?>" class="view-deck-button">View Full Deck</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>