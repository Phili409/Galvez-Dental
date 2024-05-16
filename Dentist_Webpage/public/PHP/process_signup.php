<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to mysqli session & handle errors
$conn = new mysqli($servername, $username, $password, $dbname, 22);
if ($conn->connect_error)
{
    die("Connection Failed: ". $conn->connect_error);
}

// Retrive values from client end
$firstName = $_POST['first-name'] ?? null;
$middleInitial = $_POST['middle-initial'] ?? null;
$lastName = $_POST['last-name'] ?? null;
$DOB = $_POST['DOB'] ?? null;  
$SSN = $_POST['SSN'] ?? null;
$address1 = $_POST['address1'] ?? null;
$address2 = $_POST['address2'] ?? null;
$city = $_POST['city'] ?? null;
$state = $_POST['state'] ?? null;
$zipCode = $_POST['zip'] ?? null;
$email = $_POST['email'] ?? null;
$phone = $_POST['phone'] ?? null;
$medicalBackground = $_POST['medical-background'] ?? null;
$ageGroup = $_POST['age-group'] ?? null;
$coffeeIntake = $_POST['coffee-consumption'] ?? null; 
$insured = isset($_POST['insured']) ? 1 : 0; 
$userID = $_POST['userID'] ?? null;
$password = $_POST['password1'] ?? null;

// Ensure datetime 
if($DOB)
{
    $date = new DateTime($DOB);
    $DOB  = $date->format('Y-m-d'); 
}
// Hash sensitive values 
$SSNHashed = password_hash($_POST['SSN'], PASSWORD_DEFAULT); // Hash SSN
$passwordHashed = password_hash($_POST['password1'], PASSWORD_DEFAULT); // Hash password

// Prepare SQL script 
$sql = "INSERT INTO GaboTable (firstName, middleInitial, lastName, DOB, SSNHashed, address1, address2, city, state, zipCode, email, phone, ageGroup, medicalBackground, insured, coffeeIntake, userID, passwordHashed)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if(!$stmt)
{
    die('MySQL prepare error: ' . $conn->error);
}

// Bind parameters
$bind = $stmt->bind_param("ssssssssssssssiiss", $firstName, $middleInitial, $lastName, $DOB, $SSNHashed, $address1, $address2, $city, $state, $zipCode, $email, $phone, $ageGroup, $medicalBackground, $insured, $coffeeIntake, $userID, $passwordHashed);


// Check for valid binding
if(false === $bind)
{
    die('MySQL bind error: ' . $stm->error);
}

// execute 
if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>