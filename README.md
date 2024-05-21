# Movie Rating Application

This is a movie rating application built with PHP, MySQL, and MongoDB. The application allows users to view a list of movies and rate them. It demonstrates the integration of relational and non-relational databases.

## Table of Contents

- [Setup Instructions](#setup-instructions)
- [Features](#features)
- [Database Schema](#database-schema)
- [Project Structure](#project-structure)
- [Usage](#usage)
- [Future Enhancements](#future-enhancements)
- [License](#license)

## Setup Instructions

### Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html)
- Composer (for MongoDB PHP Library)

### Installation

1. **Install XAMPP:**
   - Download and install XAMPP from [here](https://www.apachefriends.org/index.html).

2. **Start Apache and MySQL:**
   - Open the XAMPP Control Panel and start the Apache and MySQL modules.

3. **Clone the Repository:**
   - Clone this repository to your `htdocs` directory. Alternatively, download and extract the project files to `C:\xampp\htdocs\movie_app`.

4. **Create the Database:**
   - Open phpMyAdmin by navigating to `http://localhost/phpmyadmin/`.
   - Create a new database named `moviesDB`.
   - Import the `schema.sql` file to create the necessary tables.

5. **Install MongoDB PHP Library:**
   - Open a terminal and navigate to the project directory.
   - Run `composer require mongodb/mongodb` to install the MongoDB PHP library.

6. **Configure Database Connection:**
   - Edit the `connect.php` file with your database credentials if necessary.

7. **Run the Application:**
   - Open your web browser and navigate to `http://localhost/movie_app/`.

## Features

- **View Movies:** View a list of all movies with details including title, year, genre, summary, and average score.
- **Rate Movies:** Users can rate movies, and the average score is calculated and displayed.
- **MongoDB Integration:** Ratings are stored in MongoDB, and movie details are fetched from MySQL.

## Database Schema

### MySQL

**movie** table:

| Field       | Type         | Description                  |
|-------------|--------------|------------------------------|
| movieId     | INT(11)      | Primary Key                  |
| title       | VARCHAR(255) | Title of the movie           |
| year        | INT(4)       | Release year                 |
| producerId  | INT(11)      | ID of the producer           |
| genre       | VARCHAR(50)  | Genre of the movie           |
| summary     | TEXT         | Summary of the movie         |
| countryCode | VARCHAR(10)  | Country code of production   |

**score_movie** table:

| Field    | Type         | Description                  |
|----------|--------------|------------------------------|
| email    | VARCHAR(255) | Email of the user            |
| movieId  | INT(11)      | ID of the rated movie        |
| score    | INT(11)      | Score given by the user      |

### MongoDB

**movies** collection:

Each document contains:

| Field    | Type         | Description                  |
|----------|--------------|------------------------------|
| movieId  | INT          | ID of the movie              |
| ratings  | Array        | Array of rating objects      |

Each rating object contains:

| Field    | Type         | Description                  |
|----------|--------------|------------------------------|
| email    | String       | Email of the user            |
| score    | INT          | Score given by the user      |

## Project Structure
movie_app/
├── connect.php # Database connection file
├── movies_list.php # Script to display list of movies
├── user_rating.php # Script to rate a movie
├── styles.css # CSS for styling the application
├── vendor/ # Composer dependencies
├── README.md # Project documentation
└── schema.sql # SQL script to create MySQL tables


## Usage

1. **View Movies:**
   - Go to `http://localhost/movie_app/movies_list.php` to view the list of movies.

2. **Rate Movies:**
   - Go to `http://localhost/movie_app/user_rating.php` to rate a movie. Select the movie, enter your email, and provide a score.

## Future Enhancements

- **User Registration and Authentication:**
  - Allow users to register and log in to the application.
  - Implement authentication to ensure only registered users can rate movies.

- **Advanced Search Functionality:**
  - Add search functionality to filter movies by title, genre, or year.

- **Movie Recommendations:**
  - Implement a recommendation system to suggest movies to users based on their ratings.

## License

This project is licensed under the MIT License.
