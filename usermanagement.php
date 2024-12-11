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

$sql = 'SELECT id, username FROM users';
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
                <a href="#">Services</a>
                <a href="#">Contact</a>
        </nav>
    </header>





    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">High top Mountain farm management sowftware</h1>
        <p class="hero-subtitle">" why paper when we can have it centralized online! "</p>
    
        
    <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>farming is hard and we are here to make it simple for you please make a selection below to start</h2>
        </div>
    </div>


    <div class="table-container-center">
        <h2>All users in Database</h2>
        <table class="half-width-left-align">
            <thead>
                <tr>
                    <th> ID</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td>
                        <form action="vehiclemanagemet.php" method="post" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                            <input type="submit" value="Delete user">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>