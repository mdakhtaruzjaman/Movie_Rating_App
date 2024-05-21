<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

// MySQL Connection
$mysql_servername = "localhost";
$mysql_username = "root";
$mysql_password = ""; // Change to your MySQL root password if set
$mysql_dbname = "moviesDB";

try {
    $mysql_conn = new PDO("mysql:host=$mysql_servername;dbname=$mysql_dbname", $mysql_username, $mysql_password);
    $mysql_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected to MySQL successfully.<br>";
} catch (PDOException $e) {
    die("MySQL Connection failed: " . $e->getMessage());
}

// MongoDB Connection
try {
    $mongo_client = new MongoDB\Client("mongodb://localhost:27017");
    $mongo_db = $mongo_client->moviesDB;
    $mongo_collection = $mongo_db->movies; // Change 'movies' to your actual collection name
    echo "Connected to MongoDB successfully.<br>";
} catch (Exception $e) {
    die("MongoDB Connection failed: " . $e->getMessage());
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $movieId = $_POST['movieId'];
    $score = $_POST['score'];

    try {
        // Check if the movieId exists in MySQL
        $stmt = $mysql_conn->prepare("SELECT * FROM Movie WHERE movieId = ?");
        $stmt->execute([$movieId]);
        $mysql_movie = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($mysql_movie) {
            // Check if the rating already exists
            $stmt = $mysql_conn->prepare("SELECT * FROM score_movie WHERE email = ? AND movieId = ?");
            $stmt->execute([$email, $movieId]);

            if ($stmt->rowCount() > 0) {
                // Update existing rating
                $stmt = $mysql_conn->prepare("UPDATE score_movie SET score = ? WHERE email = ? AND movieId = ?");
                $stmt->execute([$score, $email, $movieId]);
                echo "<p>Rating updated successfully in MySQL</p>";
            } else {
                // Insert new rating
                $stmt = $mysql_conn->prepare("INSERT INTO score_movie (email, movieId, score) VALUES (?, ?, ?)");
                $stmt->execute([$email, $movieId, $score]);
                echo "<p>New rating added successfully in MySQL</p>";
            }

            // Update or insert rating in MongoDB
            $mongo_movie = $mongo_collection->findOne(['movieId' => intval($movieId)]);

            if ($mongo_movie) {
                // Check if rating by this email exists in MongoDB
                $existingRating = false;
                foreach ($mongo_movie['ratings'] as &$rating) {
                    if ($rating['email'] === $email) {
                        $rating['score'] = $score;
                        $existingRating = true;
                        break;
                    }
                }
                if (!$existingRating) {
                    $mongo_movie['ratings'][] = ['email' => $email, 'score' => $score];
                }
                $mongo_collection->updateOne(
                    ['movieId' => intval($movieId)],
                    ['$set' => ['ratings' => $mongo_movie['ratings']]]
                );
                echo "<p>Rating updated successfully in MongoDB</p>";
            } else {
                echo "<p>Movie not found in MongoDB</p>";
            }
        } else {
            echo "<p>Movie ID does not exist in MySQL</p>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch movies to display in the form
try {
    $stmt = $mysql_conn->query("SELECT movieId, title FROM Movie");
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rate a Movie</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Rate a Movie</h1>
        <form method="POST" action="">
            Email: <input type="email" name="email" required><br>
            Movie:
            <select name="movieId" required>
                <?php foreach ($movies as $movie): ?>
                    <option value="<?php echo htmlspecialchars($movie['movieId']); ?>">
                        <?php echo htmlspecialchars($movie['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select><br>
            Score: <input type="number" name="score" min="1" max="10" required><br>
            <input type="submit" name="submit" value="Submit Rating">
        </form>
    </div>
    <div class="footer">
        <p>Movies Portal &copy; 2024</p>
    </div>
</body>
</html>
