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
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Handle book search
$search_results = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = '%' . $_GET['search'] . '%';
    $search_sql = 'SELECT student_id, student_name, class_grade FROM lea WHERE student_id LIKE :search';
    $search_stmt = $pdo->prepare($search_sql);
    $search_stmt->execute(['search' => $search_term]);
    $search_results = $search_stmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['student_id']) && isset($_POST['student_name']) && isset($_POST['class_grade'])) {
        // Insert new entry
        $student_id = htmlspecialchars($_POST['student_id']);
        $student_name = htmlspecialchars($_POST['student_name']);
        $class_grade = htmlspecialchars($_POST['class_grade']);
        
        $insert_sql = 'INSERT INTO lea (student_id, student_name, class_grade) VALUES (:student_id, :student_name, :class_grade)';
        $stmt_insert = $pdo->prepare($insert_sql);
        $stmt_insert->execute(['student_id' => $student_id, 'student_name' => $student_name, 'class_grade' => $class_grade]);
    } elseif (isset($_POST['delete_id'])) {
        // Delete an entry
        $delete_id = (int) $_POST['delete_id'];
        
        $delete_sql = 'DELETE FROM lea WHERE student_id = :student_id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['student_id' => $delete_id]);
    }
}

// get everything for main table
$sql = 'SELECT student_id, student_name, class_grade FROM lea';
$stmt = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Display</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">Blackboard Student Management System</h1>
        
        <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>Search for a Student</h2>
            <form action="" method="GET" class="search-form">
                <label for="search">Search by Student ID (774):</label>
                <input type="text" id="search" name="search" required>
                <input type="submit" value="Search">
            </form>
            
            <?php if (isset($_GET['search'])): ?>
                <div class="search-results">
                    <h3>Search Results</h3>
                    <?php if ($search_results && count($search_results) > 0): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['class_grade']); ?></td>
                                    <td>
                                        <form action="index1.php" method="post" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['student_id']; ?>">
                                            <input type="submit" value="Drop from course">
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No students found matching your search.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <h2>Add New Entry</h2>
    <form action="index1.php" method="post">
        <label for="student_id">Student ID:</label>
        <input type="text" id="student_id" name="student_id" required>
        <br><br>
        <label for="student_name">Student Name:</label>
        <input type="text" id="student_name" name="student_name" required>
        <br><br>
        <label for="class_grade">Class Grade:</label>
        <input type="text" id="class_grade" name="class_grade" required>
        <br><br>
        <input type="submit" value="Add Entry">
    </form>

    <h1>Data Listing from Table 'lea'</h1>
    <table class="half-width-left-align">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Class Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                <td><?php echo htmlspecialchars($row['class_grade']); ?></td>
                <td>
                    <form action="index1.php" method="post" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $row['student_id']; ?>">
                        <input type="submit" value="Delete">
                        <!-- this line will do a confirmation
                        <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this entry?');">
            --> 
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>