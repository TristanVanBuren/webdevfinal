<?php
session_start();
require_once 'auth.php';

// Check if user is logged in
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}
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
            <h2>farming is hard and we are here to make it simple for you please make a selection below to start</h2>
        </div>
    </div>


<!--gpt alert-->
    <div class="flex-container">
        <div class="flex-item"><a href= vehiclemanagemet.php> Vehicle Management </a></div>
        <div class="flex-item"><a href="usermanagement.php">user management</a></div>
        <div class="flex-item"><a href="toolmanagement.php">Tool Management </a></div>
        <div class="flex-item"><a href="jodmanagement.php">Job of the Day Management </a></div>
        <div class="flex-item"><a href="index.php"> main page</a></div>
    </div>
    



</body>