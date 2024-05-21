CREATE DATABASE IF NOT EXISTS moviesDB;
USE moviesDB;

CREATE TABLE Country (
    code CHAR(3) PRIMARY KEY,
    name VARCHAR(100),
    language VARCHAR(100)
);

CREATE TABLE Movie (
    movieId INT PRIMARY KEY,
    title VARCHAR(255),
    year YEAR,
    genre VARCHAR(100),
    summary TEXT,
    producerId INT,
    countryCode CHAR(3),
    FOREIGN KEY (countryCode) REFERENCES Country(code)
);

CREATE TABLE Artist (
    artistId INT PRIMARY KEY,
    surname VARCHAR(100),
    name VARCHAR(100),
    DOB DATE
);

CREATE TABLE Role (
    movieId INT,
    actorId INT,
    roleName VARCHAR(100),
    PRIMARY KEY (movieId, actorId),
    FOREIGN KEY (movieId) REFERENCES Movie(movieId),
    FOREIGN KEY (actorId) REFERENCES Artist(artistId)
);

CREATE TABLE Internet_user (
    email VARCHAR(255) PRIMARY KEY,
    surname VARCHAR(100),
    name VARCHAR(100),
    region VARCHAR(100)
);

CREATE TABLE Score_movie (
    email VARCHAR(255),
    movieId INT,
    score INT,
    PRIMARY KEY (email, movieId),
    FOREIGN KEY (email) REFERENCES Internet_user(email),
    FOREIGN KEY (movieId) REFERENCES Movie(movieId)
);
