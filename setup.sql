-- Drops DB if it exists
DROP DATABASE IF EXISTS bankap;

-- Creates new DB
CREATE DATABASE bankapp;

-- Switch to new DB
USE bankapp;

-- Creates new users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert test user
INSERT INTO users (email, password)
VALUES ('user1@example.com', MD5('password123'));

-- USAGE
-- In terminal: sudo mysql -u root -p < setup.sql
--      This deletes old bankapp databases, creates a new one, creates user table, adds test user