-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 03:25 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9


-- Database: `nacos-vote`


-- Table structure for casted votes and users
--

CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matric VARCHAR(20) UNIQUE NOT NULL,
    president VARCHAR(255) NOT NULL,
    vicePresident VARCHAR(255) NOT NULL
);


--Table structure for registering users

--

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matric_number VARCHAR(20) UNIQUE NOT NULL,
    username VARCHAR(255) NOT NULL
);

