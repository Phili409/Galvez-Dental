<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Display errors during back end runtime
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to mysqli session
$conn = new mysqli($servername, $username, $password, $dbname, 22);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a table for SQL use 
$sql = "CREATE TABLE GaboTable (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    dateCreated DATETIME DEFAULT CURRENT_TIMESTAMP,
    dateModified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    dateAccessed DATETIME DEFAULT NULL,
    dateInactive DATETIME DEFAULT NULL,
    userType CHAR(1) DEFAULT 'U',
    userStatus CHAR(1) DEFAULT 'A',
    firstName VARCHAR(30) NOT NULL,
    middleInitial CHAR(1),
    lastName VARCHAR(30) NOT NULL,
    DOB DATE NOT NULL,
    SSNHashed VARCHAR(255) NOT NULL,
    address1 VARCHAR(50) NOT NULL,
    address2 VARCHAR(50),
    city VARCHAR(30) NOT NULL,
    state CHAR(2) NOT NULL,
    zipCode VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    ageGroup VARCHAR(10),
    medicalBackground TEXT,
    insured BOOLEAN NOT NULL DEFAULT 0,
    coffeeIntake TINYINT DEFAULT NULL,
    userID VARCHAR(20) NOT NULL UNIQUE,
    passwordHashed VARCHAR(255) NOT NULL
    )";

if ($conn->query($sql) === TRUE) {
    echo "Table GaboTable created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>