<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Draftsman</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="draftsman_favicon.ico" type="image/x-icon">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        .about-container {
            margin: 20px;
        }
        .about-header {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #17829d;
            color: white;
            border-radius: 8px;
        }
        .about-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .about-section, .forum-section, .threads-container {
            margin: 20px 0;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        .about-section:nth-child(odd), .forum-section, .threads-container {
            background-color: #f4f4f4;
        }
        .about-section:nth-child(even) {
            background-color: #e1ecf4;
        }
        .about-section h2, .forum-section h2, .threads-container h2 {
            text-align: center;
        }
        .forum-section form {
            display: flex;
            flex-direction: column;
        }
        .forum-section label, .forum-section input, .forum-section textarea {
            margin: 10px 0;
            width: 100%;
        }
        .forum-section button {
            padding: 10px;
            background-color: #17829d;
            color: white;
            border: none;
            cursor: pointer;
            align-self: center;
            border-radius: 4px;
        }
        .forum-section button:hover {
            background-color: #036982;
        }
        .thread-item {
            background-color: #fff;
            padding: 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="index.php">
                <img src="draftsman_logo.png" alt="Draftsman Logo" style="height: 48px; vertical-align: middle;">
                Draftsman
            </a> | 
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
        <div class="about-container">
            <h1 class="about-header">About Draftsman</h1>
            <div class="about-content">
                <div class="about-section">
                    <h2>Our Mission</h2>
                    <p>
                        At Draftsman, we aim to revolutionize the world of card game enthusiasts by providing a robust and user-friendly deck-building platform. Our mission is to empower players to craft their unique decks with ease and confidence, enhancing their gaming experience through innovative tools and a vibrant community.
                    </p>
                </div>
                <div class="about-section">
                    <h2>Our Story</h2>
                    <p>
                        Draftsman was born out of a passion for card games and a desire to make deck building accessible to everyone. What started as a small project quickly grew into a comprehensive platform, thanks to the support and feedback from our dedicated users. Today, Draftsman is a leading tool for players around the world, offering unmatched features and flexibility.
                    </p>
                </div>
                <div class="about-section">
                    <h2>Our Team</h2>
                    <p>
                        We are a diverse group of developers, designers, and card game enthusiasts committed to delivering the best possible experience for our users. Our team is driven by creativity, innovation, and a shared love for gaming. We work tirelessly to improve Draftsman and introduce new features that cater to the evolving needs of our community.
                    </p>
                </div>
                <div class="about-section">
                    <h2>Contact Us</h2>
                    <p>
                        We love hearing from our users! If you have any questions, feedback, or just want to say hello, feel free to reach out to us at <a href="mailto:support@draftsman.com">support@draftsman.com</a>. Your input helps us grow and improve.
                    </p>
                </div>
                <div class="forum-section">
                    <h2>Create a Forum Thread</h2>
                    <form action="create_thread.php" method="POST">
                        <label for="title">Thread Title</label>
                        <input type="text" id="title" name="title" required>
                        <label for="content">Thread Content</label>
                        <textarea id="content" name="content" rows="5" required></textarea>
                        <label for="email">Your Email (Optional)</label>
                        <input type="email" id="email" name="email">
                        <button type="submit">Create Thread</button>
                    </form>
                </div>
                <div class="threads-container">
                    <h2>Forum Threads</h2>
                    <?php
                    // Database connection
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

                        // Fetch threads from the database
                        $stmt = $conn->prepare("SELECT * FROM forum_threads ORDER BY created_at DESC");
                        $stmt->execute();
                        $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($threads)) {
                            foreach ($threads as $thread) {
                                echo "<div class='thread-item'>";
                                echo "<h3>" . htmlspecialchars($thread['title']) . "</h3>";
                                echo "<p>" . nl2br(htmlspecialchars($thread['content'])) . "</p>";
                                if ($thread['email']) {
                                    echo "<p>Contact: <a href='mailto:" . htmlspecialchars($thread['email']) . "'>" . htmlspecialchars($thread['email']) . "</a></p>";
                                }
                                echo "<p><small>Posted on: " . htmlspecialchars($thread['created_at']) . "</small></p>";
                                echo "</div>";
                            }
                        } else {
                            echo "<p>No forum threads found.</p>";
                        }
                    } catch (PDOException $e) {
                        echo "Connection failed: " . $e->getMessage();
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
