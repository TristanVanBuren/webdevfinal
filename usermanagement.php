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
        
        $delete_sql = 'DELETE FROM users WHERE id = :id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['id' => $delete_id]);
    }
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
            
                <a href="navpage.php">Dashboard</a>
                <a href= vehiclemanagemet.php> Vehicle  </a>
                <a href="usermanagement.php">Users</a>
                <a href="toolmanagement.php">Tools</a>
                <a href="jodmanagement.php">JOD</a>
                <a href="index.php">Home</a>
        </nav>
    </header>





    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">High top Mountain farm management sowftware</h1>
        <p class="hero-subtitle">" why paper when we can have it centralized online! "</p>
    
        
    <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>Don't mess with this or you have to fix it</h2>
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
                        <form action="usermanagement.php" method="post" style="display:inline;">
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