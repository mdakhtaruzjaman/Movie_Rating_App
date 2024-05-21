<!DOCTYPE html>
<html>
<head>
    <title>Insert Data</title>
</head>
<body>
<?php
include 'connect.php';

// Start transaction
$conn->begin_transaction();

try {
    // Prepared statement for Country table
    $stmt = $conn->prepare("INSERT INTO Country (code, name, language) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $code, $name, $language);

    $countries = [
        ['USA', 'United States', 'English'],
        ['FRA', 'France', 'French'],
        ['GBR', 'United Kingdom', 'English']
    ];
    foreach ($countries as $country) {
        [$code, $name, $language] = $country;
        $stmt->execute();
    }
    echo "New records created successfully in Country table<br>";
    $stmt->close();

    // Prepared statement for Movie table
    $stmt = $conn->prepare("INSERT INTO Movie (movieId, title, year, genre, summary, producerId, countryCode) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isissis", $movieId, $title, $year, $genre, $summary, $producerId, $countryCode);

    $movies = [
        [1, 'Inception', 2010, 'Sci-Fi', 'A mind-bending thriller', 1, 'USA'],
        [2, 'Amélie', 2001, 'Romantic Comedy', 'A quirky French girl helps those around her', 2, 'FRA']
    ];
    foreach ($movies as $movie) {
        [$movieId, $title, $year, $genre, $summary, $producerId, $countryCode] = $movie;
        $stmt->execute();
    }
    echo "New records created successfully in Movie table<br>";
    $stmt->close();

    // Prepared statement for Artist table
    $stmt = $conn->prepare("INSERT INTO Artist (artistId, surname, name, DOB) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $artistId, $surname, $name, $DOB);

    $artists = [
        [1, 'Nolan', 'Christopher', '1970-07-30'],
        [2, 'Jeunet', 'Jean-Pierre', '1953-09-03']
    ];
    foreach ($artists as $artist) {
        [$artistId, $surname, $name, $DOB] = $artist;
        $stmt->execute();
    }
    echo "New records created successfully in Artist table<br>";
    $stmt->close();

    // Prepared statement for Role table
    $stmt = $conn->prepare("INSERT INTO Role (movieId, actorId, roleName) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $movieId, $actorId, $roleName);

    $roles = [
        [1, 1, 'Director'],
        [2, 2, 'Director']
    ];
    foreach ($roles as $role) {
        [$movieId, $actorId, $roleName] = $role;
        $stmt->execute();
    }
    echo "New records created successfully in Role table<br>";
    $stmt->close();

    // Prepared statement for Internet_user table
    $stmt = $conn->prepare("INSERT INTO Internet_user (email, surname, name, region) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $surname, $name, $region);

    $users = [
        ['user1@example.com', 'Doe', 'John', 'North America'],
        ['user2@example.com', 'Smith', 'Jane', 'Europe']
    ];
    foreach ($users as $user) {
        [$email, $surname, $name, $region] = $user;
        $stmt->execute();
    }
    echo "New records created successfully in Internet_user table<br>";
    $stmt->close();

    // Prepared statement for Score_movie table
    $stmt = $conn->prepare("INSERT INTO Score_movie (email, movieId, score) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $email, $movieId, $score);

    $scores = [
        ['user1@example.com', 1, 9],
        ['user2@example.com', 2, 8]
    ];
    foreach ($scores as $score) {
        [$email, $movieId, $score] = $score;
        $stmt->execute();
    }
    echo "New records created successfully in Score_movie table<br>";
    $stmt->close();

    // Commit transaction
    $conn->commit();

} catch (Exception $e) {
    // Rollback transaction if any error occurs
    $conn->rollback();
    echo "Failed to insert data: " . $e->getMessage();
}

$conn->close();
?>
</body>
</html>
