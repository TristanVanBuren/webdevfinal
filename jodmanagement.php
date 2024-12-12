<?php
$host = 'localhost'; 
$dbname = 'test'; 
$user = 'tristan'; 
$pass = 'tristan';
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete_id'])) {
        // Delete an entry
        $delete_id = (int) $_POST['delete_id'];
        
        $delete_sql = 'DELETE FROM jod WHERE id = :id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['id' => $delete_id]);
    }
        else if (isset($_POST['who']) && isset($_POST['body']) ) {
            // Insert new entry
            $who = htmlspecialchars($_POST['who']);
            $body = htmlspecialchars($_POST['body']);
            
            
}
}


$sql = 'SELECT who, body FROM jod';
$stmt = $pdo->query($sql);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farm Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
        <nav>
            
                <a href="navpage.php">Home</a>
                <a href= vehiclemanagemet.php> Vehicle Management </a>
                <a href="usermanagement.php">users</a>
                <a href="#">Contact</a>
        </nav>
    </header>





    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">High top Mountain farm management sowftware</h1>
        <p class="hero-subtitle">" why paper when we can have it centralized online! "</p>
    
        
    <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>please clean up after yourself</h2>
        </div>
    </div>


    <div class="table-container-center">
        <h2>current message</h2>
        <table class="half-width-left-align">
            <thead>
                <tr>
                    <th>Made by</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['who']); ?></td>
                    <td><?php echo htmlspecialchars($row['body']); ?></td>
                    <td>
                        <form action="jodmanagement.php" method="post" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Delete message">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="form-container-center">
        <div class= "centered-items">
            <h2>add tool</h2>
            <form action="jodmanagement.php" method="post">
                <label for="who">Name:</label>
                <input type="text" id="who" name="who_name" required>
                <br><br>
                <label for="body">message:</label>
                <input type="text" id="body" name="body_type" required>
                <br><br>
                <input type="submit" value="add message">
            </form>
        </div>
    </div>
</body>