CREATE DATABASE travel_agency;
USE travel_agency;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255),
    token_expiration DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE password_resets (
    email VARCHAR(100) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    PRIMARY KEY (token),
    FOREIGN KEY (email) REFERENCES users(email)
);
