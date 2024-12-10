<?php
// Include the database connection
$host = 'localhost'; // Replace with your DB host
$username = 'root'; // Replace with your DB username
$password = ''; // Replace with your DB password
$dbname = 'your_database_name'; // Replace with your DB name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a search term is provided
if (isset($_GET['term'])) {
    $searchTerm = $conn->real_escape_string($_GET['term']);

    // Fetch cards matching the search term
    $query = "SELECT card_id, name FROM cards WHERE name LIKE ? LIMIT 10";
    $stmt = $conn->prepare($query);
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $cards = [];
    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }

    // Return JSON response
    echo json_encode($cards);

    $stmt->close();
}

$conn->close();
?>
