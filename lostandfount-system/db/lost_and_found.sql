-- Create the database
CREATE DATABASE lost_and_found;
USE lost_and_found;

-- Table for users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(15),
    branch VARCHAR(100),
    user_type ENUM('Student', 'Teaching Staff', 'Non-Teaching Staff'),
    password VARCHAR(255)
);

-- Table for lost/found items
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(100),
    description TEXT,
    item_type ENUM('Lost', 'Found'),
    report_date DATE,
    location VARCHAR(100),
    image_path VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);
