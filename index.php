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

$sql = 'SELECT who, body FROM jod';
$stmt = $pdo->query($sql);

$sql2 = 'SELECT vehicle_name FROM `data` where broken = 0 UNION SELECT tool_name FROM tools WHERE broken = 0;';
$stmt2 = $pdo->query($sql2);


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
            
                <a href="navpage.php">Admin dashboard</a>
        </nav>
    </header>





    <!-- Hero Section -->
    <div class="hero-section">
        <h1 class="hero-title">High top Mountain farm management sowftware</h1>
        <p class="hero-subtitle">" why paper when we can have it centralized online! "</p>
    
        
    <!-- Search moved to hero section -->
        <div class="hero-search">
           <h1> below you will find the jobs of the day</h1>
           
           
        </div>
    </div>
    <div class="hero-search">
           <h1> Tristan FIX THESE:</h1>
           
           <?php while ($row = $stmt2->fetch()): ?>
           <?php echo htmlspecialchars($row['vehicle_name']),", " ; ?>
           <?php endwhile; ?>
    </div>

    <br>
    <div class="hero-search">
           <h1> general annoucements</h1>
           
           <?php while ($row = $stmt->fetch()): ?>
           <hr>
           <?php echo nl2br(htmlspecialchars($row['body']));?>
           <br><br>
           <?php endwhile; ?>
    </div>





</body>