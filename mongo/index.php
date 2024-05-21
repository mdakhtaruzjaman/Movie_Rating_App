<?php
require 'vendor/autoload.php'; // Include Composer's autoloader

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->movie_db->movies;

$movies = $collection->find()->toArray();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Grid View</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .movie-card {
            margin-bottom: 20px;
        }
        .movie-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        .movie-card .card-body {
            padding: 15px;
        }
        .movie-card .card-title {
            margin-bottom: 10px;
            font-size: 1.25rem;
        }
        .movie-card .card-text {
            font-size: 1rem;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Movies</h1>
    <div class="row">
        <?php foreach ($movies as $movie): ?>
            <div class="col-md-4">
                <div class="card movie-card">
                    <img src="<?php echo htmlspecialchars($movie['poster_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($movie['title']); ?></h5>
                        <p class="card-text"><strong>Year:</strong> <?php echo htmlspecialchars($movie['year']); ?></p>
                        <p class="card-text"><strong>Genre:</strong> <?php echo htmlspecialchars($movie['genre']); ?></p>
                        <p class="card-text"><?php echo htmlspecialchars($movie['summary']); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>