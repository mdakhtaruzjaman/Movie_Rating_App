<?php
include 'connect.php';

try {
    // Fetch all movies from MySQL
    $sql = "SELECT * FROM movie";
    $stmt = $mysql_conn->query($sql);
    $mysql_movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $movies = [];

    // Iterate through MySQL movies
    foreach ($mysql_movies as $mysql_movie) {
        // Find corresponding movie in MongoDB
        $mongo_movie = $mongo_collection->findOne(['movieId' => $mysql_movie['movieId']]);

        // Calculate the average score
        $average_score = 0;
        if ($mongo_movie && isset($mongo_movie['ratings']) && count($mongo_movie['ratings']) > 0) {
            $total_score = 0;
            $count = 0;
            foreach ($mongo_movie['ratings'] as $rating) {
                $total_score += $rating['score'];
                $count++;
            }
            $average_score = $total_score / $count;
        }

        // Add movie details along with average score to the array
        $movies[] = [
            'title' => $mysql_movie['title'],
            'year' => $mysql_movie['year'],
            'genre' => $mysql_movie['genre'],
            'summary' => $mysql_movie['summary'],
            'average_score' => $average_score
        ];
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Movies List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Movies List</h1>
        <table>
            <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Summary</th>
                <th>Average Score</th>
            </tr>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($movie['title']); ?></td>
                    <td><?php echo htmlspecialchars($movie['year']); ?></td>
                    <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                    <td><?php echo htmlspecialchars($movie['summary']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($movie['average_score'], 2)); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="footer">
        <p>Movies Portal &copy; 2024</p>
    </div>
</body>
</html>


