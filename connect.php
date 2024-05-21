<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// MySQL Connection Configuration
$mysql_servername = "localhost";
$mysql_username = "root";
$mysql_password = ""; // Change to your MySQL root password if set
$mysql_dbname = "moviesDB";

// Establish MySQL Connection
try {
    $mysql_conn = new PDO("mysql:host=$mysql_servername;dbname=$mysql_dbname", $mysql_username, $mysql_password);
    // Set the PDO error mode to exception
    $mysql_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to MySQL successfully.<br>";
} catch (PDOException $e) {
    die("MySQL Connection failed: " . $e->getMessage());
}

// MongoDB Connection Configuration
try {
    $mongo_client = new MongoDB\Client("mongodb://localhost:27017");
    $mongo_db = $mongo_client->moviesDB;
    $mongo_collection = $mongo_db->movies; // Change 'movies' to your actual collection name if different
    echo "Connected to MongoDB successfully.<br>";
} catch (Exception $e) {
    die("MongoDB Connection failed: " . $e->getMessage());
}
?>





