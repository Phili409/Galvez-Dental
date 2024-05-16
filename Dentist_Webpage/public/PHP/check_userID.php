<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Connect to mysqli session
$conn = new mysqli($servername, $username, $password, $dbname, 22);
if ($conn->connect_error)
{
    die("Connection Failed: ". $conn->connect_error);
}

// Value from front end communication
$value = $_GET['userID'] ?? ''; 

// SQL query to look for match for value
$sql = "SELECT EXISTS(SELECT 1 FROM `GaboTable` WHERE `userID` = ?) AS `exists`";

// Prepare the execution
$q = $conn->prepare($sql);
$q->bind_param("s", $userID); // To avoid SQL injections
$q->execute(); // execute

// Get Result
$q->bind_result($exists);

// Output Result 
if($q->fetch())
{
    echo json_encode(['value_exists' => $exists]);
}
else
{
    echo json_encode(['value_exists' => false]);
}

// Close connections
$q->close();
$conn->close();
?>