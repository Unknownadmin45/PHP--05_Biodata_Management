<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Biodata_DB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Create Database
$sql = "CREATE DATABASE IF NOT EXISTS Biodata_DB";

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Users table
$sql = "CREATE TABLE IF NOT EXISTS Users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
   // echo "Table Users created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Create Biodata table
$sql = "CREATE TABLE IF NOT EXISTS Biodata (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    full_name VARCHAR(50),
    birth_name VARCHAR(50),
    birth_date DATE,
    birth_place VARCHAR(50),
    birth_time TIME,
    rashi VARCHAR(50),
    mangal_dosh VARCHAR(10),
    marital_status VARCHAR(20),
    gotra VARCHAR(50),
    mamkul VARCHAR(50),
    family_type VARCHAR(50),
    father_name VARCHAR(50),
    father_occupation VARCHAR(50),
    mother_name VARCHAR(50),
    mother_occupation VARCHAR(50),
    siblings TEXT,
    highest_education VARCHAR(50),
    additional_degree VARCHAR(50),
    occupation VARCHAR(50),
    annual_income VARCHAR(50),
    height VARCHAR(10),
    weight VARCHAR(10),
    complexion VARCHAR(20),
    blood_type VARCHAR(5),
    physical_status VARCHAR(50),
    contact VARCHAR(15),
    location VARCHAR(100)
)";

if ($conn->query($sql) === TRUE) {
    //echo "Table Biodata created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}
?>
