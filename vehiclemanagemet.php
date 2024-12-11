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

// Handle tool search
$search_results = null;
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = '%' . $_GET['search'] . '%';
    $search_sql = 'SELECT tool_id, vehicle_name, tool_type, `hours`, running FROM `data` WHERE vehicle_name LIKE :search';
    $search_stmt = $pdo->prepare($search_sql);
    $search_stmt->execute(['search' => $search_term]);
    $search_results = $search_stmt->fetchAll();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['vehicle_name']) && isset($_POST['tool_type']) && isset($_POST['hours'])) {
        // Insert new entry
        $vehicle_name = htmlspecialchars($_POST['vehicle_name']);
        $tool_type = htmlspecialchars($_POST['tool_type']);
        $hours = htmlspecialchars($_POST['hours']);
        $tool_id = null;
        
        $insert_sql = 'INSERT INTO `data` (tool_id, vehicle_name, tool_type, `hours`) VALUES (:tool_id, :vehicle_name, :tool_type, :hours)';
        $stmt_insert = $pdo->prepare($insert_sql);
        $stmt_insert->execute(['tool_id' => $tool_id, 'vehicle_name' => $vehicle_name, 'tool_type' => $tool_type, 'hours' => $hours]);
    } elseif (isset($_POST['delete_id'])) {
        // Delete an entry
        $delete_id = (int) $_POST['delete_id'];
        
        $delete_sql = 'DELETE FROM `data` WHERE tool_id = :id';
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute(['id' => $delete_id]);
    }
}


$sql = 'SELECT tool_id, vehicle_name, tool_type, `hours`, running FROM `data`';
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
        <h1 class="hero-title">High top mount farm equipment management</h1>
        <p class="hero-subtitle">" Because f*** paper and spreadsheets "</p>
        
        <!-- Search moved to hero section -->
        <div class="hero-search">
            <h2>Search for a tool</h2>
            <form action="" method="GET" class="search-form">
                <label for="search">Search by Name:</label>
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
                                    <th>Vehicle ID</th>
                                    <th>Vehicle name</th>
                                    <th>Vehicle type</th>
                                    <th>Hours/Milage</th>
                                    <th>Running</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($search_results as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['tool_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['vehicle_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tool_type']); ?></td>
                                    <td><?php echo htmlspecialchars($row['hours']); ?></td>
                                    <td><?php if(($row['running']) == 1){echo "true";} else{echo "down";} ?></td>
                                    <td>
                                        <form action="vehiclemanagemet.php" method="post" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['tool_id']; ?>">
                                            <input type="submit" value="GET OUT OF HERE!">
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No vehicles found matching your search.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Table section with container -->
    <div class="table-container-center">
        <h2>All equipment in Database</h2>
        <table class="half-width-left-align">
            <thead>
                <tr>
                    <th>Vehicle ID</th>
                    <th>Vehicle name</th>
                    <th>Vehicle type</th>
                    <th>Hours/Milage</th>
                    <th>Running</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['tool_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['vehicle_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['tool_type']); ?></td>
                    <td><?php echo htmlspecialchars($row['hours']); ?></td>
                    <td><?php if(($row['running']) == 1){echo "true";} else{echo "down";} ?></td>
                    <td>
                        <form action="vehiclemanagemet.php" method="post" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $row['tool_id']; ?>">
                            <input type="submit" value="TO THE SHADOW REALM PIECE OF S***!">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Form section with container -->
    <div class="form-container-center">
        <div class= "centered-items">
            <h2>add tool</h2>
            <form action="vehiclemanagemet.php" method="post">
                <label for="vehicle_name">Name:</label>
                <input type="text" id="vehicle_name" name="vehicle_name" required>
                <br><br>
                <label for="tool_type">Tool Type:</label>
                <input type="text" id="tool_type" name="tool_type" required>
                <br><br>
                <label for="hours">Hours/Mi: </label>
                <input type="number" id="hours" name="hours" required>
                <br><br>
                <input type="submit" value="Damn spent more money........">
            </form>
        </div>
    </div>
</body>
</html>