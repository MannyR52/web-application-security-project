-- Drops DB if it exists
DROP DATABASE IF EXISTS bankapp;

-- Creates new DB
CREATE DATABASE bankapp;

-- Switch to new DB
USE bankapp;

-- Creates new users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Insert test user
INSERT INTO users (username, password)
VALUES ('user1', MD5('password123')),
       ('user2', MD5('usr2123')),
       ('user3', MD5('bob363')),
       ('user4', MD5('hardpass')),
       ('user5', MD5('hello100')),
       ('user6', MD5('newpass8')),
       ('user7', MD5('bread101'));

-- USAGE
-- In terminal: sudo mysql -u root -p < setup.sql
--      This deletes old bankapp databases, creates a new one, creates user table, adds test user